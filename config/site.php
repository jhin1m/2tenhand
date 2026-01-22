<?php

return [
    'id' => env('SITE', 'mangareader'),
    'name' => env('SITE_NAME', 'mangareader'),
    'letter' => env('SITE_LETTER', 'M'),
    'scrapers' => env_array('SITE_SCRAPERS', ['hentaihand']),
    'features' => env_array('SITE_FEATURES', ['artists', 'tags', 'groups', 'categories', 'relationships', 'parodies', 'characters', 'languages', 'dmca']),
    'social' => env_array('SITE_SOCIAL', ['http://localhost']),
    'ua' => env('SITE_UA', 'UA-XXXXXXX-X'),
    'captcha' => [
        'key' => env('SITE_CAPTCHA_KEY', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXX'),
        'secret' => env('SITE_CAPTCHA_SECRET', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXX')
    ]
];