<?php

return [
    'id' => env('SITE', 'eroxhentai'),
    'name' => env('SITE_NAME', 'EroxHentai'),
    'letter' => env('SITE_LETTER', 'E'),
    'scrapers' => env_array('SITE_SCRAPERS', ['nhentaicom']),
    'features' => env_array('SITE_FEATURES', ['artists', 'tags', 'groups', 'categories', 'relationships', 'parodies', 'characters', 'languages', 'dmca']),
    'social' => env_array('SITE_SOCIAL', ['https://eroxhentai.com']),
    'ua' => env('SITE_UA', 'UA-153166130-1'),
    'captcha' => [
        'key' => env('SITE_CAPTCHA_KEY', '6Lcdk1cbAAAAAIVQIgKiyqyLqMiN02n_5HGqof9k'),
        'secret' => env('SITE_CAPTCHA_SECRET', '6Lcdk1cbAAAAAFcNgpo3QgJHQFmuelqHr_eBlfrl')
    ]
];