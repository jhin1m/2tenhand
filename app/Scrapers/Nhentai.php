<?php

namespace App\Scrapers;

use Illuminate\Support\Str;
use Carbon\Carbon;

class Nhentai extends Scraper
{
    public function getPageCount($tries = 3)
    {
        $crawler = $this->client->request('GET', 'https://nhentai.net/language/japanese', [
            'proxy' => $this->proxy,
            'verify' => false,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
            ],
        ]);
        
        if (!$crawler->filter('.pagination > a.last')->count()) {
            if (!$tries) return false;
            logger('The "'.$this->proxy.'" proxy fails - got response code '.@$this->client->getInternalResponse()->getStatusCode());
            $this->setCrawler();
            return $this->getPageCount($tries - 1);
        }
        parse_str(parse_url($crawler->filter('.pagination > a.last')->link()->getUri(), PHP_URL_QUERY), $qs);
        return $qs['page'];
    }

    public function getComics($page)
    {
        $crawler = $this->client->request('GET', 'https://nhentai.net/language/japanese/?page='.$page);
        $comics = [];
        $crawler->filter('.container > .gallery')->each(function ($node) use (&$comics) {
            $comics[] = [
                'link' => $node->children('a')->link()->getUri(),
                'title' => $node->filter('.caption')->text()
            ];
        });
        return $comics;
    }

    public function getComic($link)
    {
        $crawler = $this->client->request('GET', $link);
        $comic = [];
        $comic['linkcode'] = filter_var($link, FILTER_SANITIZE_NUMBER_INT) ?? null;
        $comic['cover'] = $crawler->filter('#cover img')->attr('data-src');
        $title = $crawler->filter('#info > h2');
        if ($title->count() && trim($title->text()) !== '') {
            $comic['title'] = $title->text();
            $comic['alternative_title'] = null;
        } else {
            $comic['title'] = $crawler->filter('#info > h1')->text();
            $comic['alternative_title'] = null;
        }
        $comic['slug'] = $this->slug($comic['title']);
        $parodies = [];
        $crawler->filter('#tags .tag-container')->eq(0)->filter('.tags > a')->each(function ($node) use (&$parodies) {
            $parodies[] = $this->processTag($node);
        });
        $comic['parodies'] = $parodies;
        $characters = [];
        $crawler->filter('#tags .tag-container')->eq(1)->filter('.tags > a')->each(function ($node) use (&$characters) {
            $characters[] = $this->processTag($node);
        });
        $comic['characters'] = $characters;
        $tags = [];
        $crawler->filter('#tags .tag-container')->eq(2)->filter('.tags > a')->each(function ($node) use (&$tags) {
            $tags[] = $this->processTag($node);
        });
        $comic['tags'] = $tags;
        $artists = [];
        $crawler->filter('#tags .tag-container')->eq(3)->filter('.tags > a')->each(function ($node) use (&$artists) {
            $artists[] = $this->processTag($node);
        });
        $comic['artists'] = $artists;
        $groups = [];
        $crawler->filter('#tags .tag-container')->eq(4)->filter('.tags > a')->each(function ($node) use (&$groups) {
            $groups[] = $this->processTag($node);
        });
        $comic['groups'] = $groups;
        $crawler->filter('#tags .tag-container')->eq(5)->filter('.tags > a')->each(function ($node) use (&$comic) {
            $language = $this->processTag($node);
            if ($language['slug'] == 'translated') {
                $comic['translated'] = true;
            } elseif ($language['slug'] == 'rewrite') {
                $comic['rewritten'] = true;
            } elseif ($language['slug'] == 'speechless') {
                $comic['speechless'] = true;
            } else {
                $comic['language'] = $language;
            }
        });

        $comic['language'] = [
            'name' => 'Japanese',
            'slug' => 'japanese'
        ];

        $categories = $crawler->filter('#tags .tag-container')->eq(6)->filter('.tags > a');
        if ($categories->count()) {
            $comic['category'] = $this->processTag($categories->first());
        }
        try {
            $upload_date = $crawler->filter('#info time');
            $comic['uploaded_at'] = Carbon::parse($upload_date->attr('datetime'))->toDateTimeString();
        } catch (\Exception $e) {
            $comic['uploaded_at'] = Carbon::now()->toDateTimeString();
        }
        $images = [];
        $crawler->filter('#thumbnail-container .thumb-container')->each(function ($node) use (&$images) {
            $url = $node->filter('.gallerythumb > img')->attr('data-src');
            $parsedUrl = parse_url($url);
            $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . '/';
            $gallery = Str::afterLast(Str::beforeLast($url, '/'), '/');
            $ext = pathinfo($url, PATHINFO_EXTENSION);
            $page = Str::before(Str::afterLast($url, '/'), 't.');
            $image['source'] = "{$baseUrl}galleries/{$gallery}/{$page}.{$ext}";
            $image['thumbnail'] = $url;
            $images[] = $image;
        });
        $comic['images'] = $images;
        return $comic;
    }

    public function processTag($node, $array = []) {
        $array['name'] = Str::title($node->filter('.name')->text(true));
        $array['slug'] = $this->slug($array['name']);
        return $array;
    }
}
