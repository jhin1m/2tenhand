<?php

namespace App\Scrapers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Nhentaicom extends Scraper
{
    public function getPageCount($tries = 3)
    {
        // Cấu hình URL API và tham số cho request
        $apiUrl = 'https://nhentai.com/api/comics';
        $queryParams = [
            'lang' => 'en',
            'q' => '',
            'sort' => 'uploaded_at',
            'order' => 'desc',
            'languages[]' => 3,
            'page' => 1
        ];
    
        try {
            // Gửi yêu cầu GET tới API với cấu hình proxy
            $response = Http::withOptions([
                'proxy' => $this->proxy,
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                ]
            ])->get($apiUrl, $queryParams);

            // Kiểm tra phản hồi từ API
            if ($response->successful()) {
                $data = $response->json();
    
                // Lấy số trang từ dữ liệu API nếu có sẵn
                if (isset($data['last_page'])) {
                    return $data['last_page'];
                }
            }
    
            // Xử lý lỗi proxy và thử lại với proxy khác nếu còn lượt thử
            if ($tries > 0) {
                echo('The "' . $this->proxy . '" proxy fails - got response code ' . $response->status());
                $this->setCrawler();
                return $this->getPageCount($tries - 1);
            }
    
        } catch (\Exception $e) {
            echo('Error fetching page count from API: ' . $e->getMessage());
        }
    
        return false;
    }
    

    public function getComics($page)
    {
        $apiUrl = 'https://nhentai.com/api/comics';
        $queryParams = [
            'sort' => 'uploaded_at',
            'order' => 'desc',
            'languages[]' => 3, //Japanese
            'page' => $page
        ];

        try {
            $response = Http::withOptions([
                'proxy' => $this->proxy,
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                    'Accept' => 'application/json',
                ]
            ])->get($apiUrl, $queryParams);

            if ($response->successful()) {
                $data = $response->json();

                $comics = [];
                foreach ($data['data'] as $comicData) {
                    $comics[] = [
                        'link' => "https://nhentai.com/api/comics" . $comicData['slug'],
                        'title' => $comicData['alternative_title']
                    ];
                }

                return $comics;
            }

        } catch (\Exception $e) {
            logger('Error fetching comics from API: ' . $e->getMessage());
        }

        return [];
    }

    public function getComic($link)
    {
        // Lấy slug từ link
        $slug = basename($link);

        // Gửi request tới API để lấy thông tin truyện
        $comicUrl = "https://nhentai.com/api/comics/{$slug}";
        $response = Http::get($comicUrl);
        if (!$response->successful()) {
            return null;
        }
        $comicData = $response->json();

        // Tạo mảng chứa dữ liệu truyện
        $comic = [];
        $comic['linkcode'] = $comicData['linkcode'] ?? null;
        $comic['title'] = $comicData['title'];
        $comic['alternative_title'] = $comicData['alternative_title'] ?? null;
        $comic['slug'] = $comicData['slug'] ?? null;
        $comic['rewritten'] = $comicData['rewritten'] ?? false;
        $comic['translated'] = $comicData['translated'] ?? false;
        $comic['speechless'] = $comicData['speechless'] ?? false;
        $comic['uploaded_at'] = isset($comicData['uploaded_at']) ? Carbon::parse($comicData['uploaded_at'])->toDateTimeString() : Carbon::now()->toDateTimeString();

        // Xử lý thông tin về ngôn ngữ, thể loại, và các thông tin khác
        $comic['language'] = [
            'name' => $comicData['language']['name'] ?? 'Unknown',
            'slug' => $comicData['language']['slug'] ?? 'unknown',
        ];

        $comic['category'] = $comicData['category'] ?? [];

        // Xử lý tags
        $comic['tags'] = array_map(function ($tag) {
            return [
                'name' => $tag['name'],
                'slug' => $tag['slug'],
                'description' => $tag['description'] ?? '',
                'color' => $tag['color'] ?? '#000000'
            ];
        }, $comicData['tags'] ?? []);

        // Xử lý parodies, characters, artists, authors, groups
        $comic['parodies'] = $comicData['parodies'] ?? [];
        $comic['characters'] = $comicData['characters'] ?? [];
        $comic['artists'] = $comicData['artists'] ?? [];
        $comic['authors'] = $comicData['authors'] ?? [];
        $comic['groups'] = $comicData['groups'] ?? [];
        $comic['relationships'] = $comicData['relationships'] ?? [];

        // Lấy thông tin ảnh từ API riêng
        $imagesUrl = "{$comicUrl}/images";
        $imagesResponse = Http::get($imagesUrl);
        if ($imagesResponse->successful()) {
            $imagesData = $imagesResponse->json();
            $comic['images'] = array_map(function ($image) {
                return [
                    'source' => $image['source_url'],
                    'thumbnail' => $image['thumbnail_url']
                ];
            }, $imagesData['images'] ?? []);
        } else {
            $comic['images'] = [];
        }

        return $comic;
    }

    public function processTag($node, $array = []) {
        $array['name'] = Str::title($node->filter('.name')->text(true));
        $array['slug'] = $this->slug($array['name']);
        return $array;
    }
}
