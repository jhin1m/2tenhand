<?php

namespace App\Scrapers;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class HentaiHand extends Scraper
{
    private $apiBase = 'https://hentaihand.com/api';

    public function getPageCount($tries = 3)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'Accept' => 'application/json',
            ])->get("{$this->apiBase}/comics", [
                        'page' => 1
                    ]);

            if (!$response->successful()) {
                if (!$tries)
                    return false;
                logger('HentaiHand API request failed - got response code ' . $response->status());
                return $this->getPageCount($tries - 1);
            }

            $data = $response->json();

            // Assuming the API returns pagination info, adjust based on actual API response
            // If the API has 'last_page' or 'total_pages' field:
            return $data['last_page'] ?? $data['total_pages'] ?? 1;
        } catch (\Exception $e) {
            logger('HentaiHand getPageCount error: ' . $e->getMessage());
            return false;
        }
    }

    public function getComics($page)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'Accept' => 'application/json',
            ])->get("{$this->apiBase}/comics", [
                        'page' => $page
                    ]);

            if (!$response->successful()) {
                logger('HentaiHand getComics failed for page ' . $page);
                return [];
            }

            $data = $response->json();
            $comics = [];

            // Assuming the API returns an array of comics in 'data' field
            // Adjust based on actual API response structure
            $comicsData = $data['data'] ?? $data['comics'] ?? $data;

            foreach ($comicsData as $comic) {
                // Use slug if available, otherwise use ID
                $identifier = $comic['slug'] ?? $comic['id'];
                $comics[] = [
                    'link' => "https://hentaihand.com/en/{$identifier}",
                    'title' => $comic['title'] ?? ''
                ];
            }

            return $comics;
        } catch (\Exception $e) {
            logger('HentaiHand getComics error: ' . $e->getMessage());
            return [];
        }
    }

    public function getComic($link)
    {
        try {
            // Extract manga ID or slug from link
            $urlParts = explode('/', trim($link, '/'));
            $identifier = end($urlParts);

            // Fetch comic data - API accepts both ID and slug
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'Accept' => 'application/json',
            ])->get("{$this->apiBase}/comics/{$identifier}");

            if (!$response->successful()) {
                throw new \Exception("Failed to fetch comic with identifier: {$identifier}");
            }

            $mangaData = $response->json();

            if (!isset($mangaData['id']) || !isset($mangaData['title'])) {
                throw new \Exception("Invalid API response structure");
            }

            $comic = [];
            $comic['linkcode'] = $mangaData['linkcode'] ?? $mangaData['id'];
            $comic['title'] = $mangaData['title'];
            $comic['slug'] = $mangaData['slug'] ?? $this->slug($comic['title']);
            $comic['alternative_title'] = $mangaData['alternative_title'] ?? null;

            // Cover image
            $comic['cover'] = $mangaData['image_url'] ?? $mangaData['thumb_url'] ?? null;

            // Tags
            $comic['tags'] = [];
            if (isset($mangaData['tags']) && is_array($mangaData['tags'])) {
                foreach ($mangaData['tags'] as $tag) {
                    $comic['tags'][] = [
                        'name' => $tag['name'],
                        'slug' => $tag['slug']
                    ];
                }
            }

            // Artists
            $comic['artists'] = [];
            if (isset($mangaData['artists']) && is_array($mangaData['artists'])) {
                foreach ($mangaData['artists'] as $artist) {
                    $comic['artists'][] = [
                        'name' => $artist['name'],
                        'slug' => $artist['slug']
                    ];
                }
            }

            // Groups
            $comic['groups'] = [];
            if (isset($mangaData['groups']) && is_array($mangaData['groups'])) {
                foreach ($mangaData['groups'] as $group) {
                    $comic['groups'][] = [
                        'name' => $group['name'],
                        'slug' => $group['slug']
                    ];
                }
            }

            // Parodies
            $comic['parodies'] = [];
            if (isset($mangaData['parodies']) && is_array($mangaData['parodies'])) {
                foreach ($mangaData['parodies'] as $parody) {
                    $comic['parodies'][] = [
                        'name' => $parody['name'],
                        'slug' => $parody['slug']
                    ];
                }
            }

            // Characters
            $comic['characters'] = [];
            if (isset($mangaData['characters']) && is_array($mangaData['characters'])) {
                foreach ($mangaData['characters'] as $character) {
                    $comic['characters'][] = [
                        'name' => $character['name'],
                        'slug' => $character['slug']
                    ];
                }
            }

            // Language
            if (isset($mangaData['language']) && $mangaData['language']) {
                $comic['language'] = [
                    'name' => $mangaData['language']['name'],
                    'slug' => $mangaData['language']['slug']
                ];
            } else {
                $comic['language'] = [
                    'name' => 'English',
                    'slug' => 'english'
                ];
            }

            // Category
            if (isset($mangaData['category'])) {
                $comic['category'] = [
                    'name' => $mangaData['category']['name'],
                    'slug' => $mangaData['category']['slug']
                ];
            }

            // Upload date
            try {
                if (isset($mangaData['uploaded_at'])) {
                    $comic['uploaded_at'] = Carbon::parse($mangaData['uploaded_at'])->toDateTimeString();
                } else {
                    $comic['uploaded_at'] = Carbon::now()->toDateTimeString();
                }
            } catch (\Exception $e) {
                $comic['uploaded_at'] = Carbon::now()->toDateTimeString();
            }

            // Fetch images using SLUG (not ID)
            $slug = $mangaData['slug'];
            $imagesResponse = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'Accept' => 'application/json',
            ])->get("{$this->apiBase}/comics/{$slug}/images");

            $images = [];
            if ($imagesResponse->successful()) {
                $imagesData = $imagesResponse->json();
                $imagesList = $imagesData['images'] ?? [];

                foreach ($imagesList as $imageData) {
                    $images[] = [
                        'source' => $imageData['source_url'] ?? '',
                        'thumbnail' => $imageData['thumbnail_url'] ?? $imageData['source_url'] ?? ''
                    ];
                }
            }

            $comic['images'] = $images;

            return $comic;
        } catch (\Exception $e) {
            logger('HentaiHand getComic error: ' . $e->getMessage());
            logger('HentaiHand getComic link: ' . $link);
            return null; // Return null instead of throwing to prevent array_merge error
        }
    }

    public function processTag($tag, $array = [])
    {
        if (is_string($tag)) {
            $array['name'] = Str::title($tag);
            $array['slug'] = $this->slug($tag);
        } elseif (is_array($tag)) {
            $array['name'] = Str::title($tag['name'] ?? '');
            $array['slug'] = $tag['slug'] ?? $this->slug($array['name']);
        }
        return $array;
    }
}
