<?php

return [

    "title" => [
        "default" => "Trang chủ",
        "404" => "Không tìm thấy trang",
        "comics" => "Truyện tranh",
        "comic" => ":title - Truyện tranh",
        "reader" => "Đọc :title",
        "characters" => "Nhân vật",
        "character" => ":name - Nhân vật",
        "artists" => "Họa sĩ",
        "artist" => ":name - Họa sĩ",
        "authors" => "Tác giả",
        "Author" => ":name - Tác giả",
        "groups" => "Nhóm dịch",
        "group" => ":name - Nhóm dịch",
        "parodies" => "Parodies",
        "parody" => ":name - Parody",
        "relationships" => "Mối quan hệ",
        "relationship" => ":name - Mối quan hệ",
        "tags" => "Thẻ",
        "tag" => ":name - Thẻ",
        "language" => ":name - Ngôn ngữ",
        "category" => ":name - Danh mục",
        "profile" => ":username - Hồ sơ",
        "settings" => "Cài đặt",
        "admin" => [
            "publishers" => "Quản lý nhà xuất bản",
            "authors" => "Quản lý tác giả",
            "artists" => "Quản lý họa sĩ",
            "genres" => "Quản lý thể loại",
            "comics" => "Quản lý truyện tranh",
            "slides" => "Quản lý slide",
        ]
    ],
    "description" => [
        "default" => config('site.name') . " là trình đọc truyện tranh hentai và doujinshi miễn phí, cập nhật liên tục với hàng ngàn bộ truyện đa ngôn ngữ.",
        "tags" => "Đọc truyện không che, lolicon, màu, big breasts và milf trên " . config('site.name') . ".",
        "comic" => ":date - Đọc và tải xuống miễn phí :title, một tác phẩm :category bởi :creators trên " . config('site.name') . ".",
        "artist" => "Đọc :count truyện hentai của :name trên " . config('site.name') . " - trình đọc hentai doujinshi và manga.",
        "author" => "Đọc :count truyện hentai của :name trên " . config('site.name') . " - trình đọc hentai doujinshi và manga.",
        "group" => ":description",
        "parody" => "Đọc :count truyện parody :name trên " . config('site.name') . ".",
        "relationship" => "Đọc :count truyện về mối quan hệ :name trên " . config('site.name') . ".",
        "category" => "Đọc :count truyện hentai danh mục :name trên " . config('site.name') . ".",
        "tag" => "Đọc :count truyện với thẻ :name trên " . config('site.name') . ".",
        "character" => "Đọc :count truyện hentai về nhân vật :name trên " . config('site.name') . ".",
        "language" => "Đọc :count truyện hentai tiếng :name trên " . config('site.name') . ".",
        "reader" => "",
        "defaults" => [
            "category" => "truyện",
            "creators" => "nhiều họa sĩ"
        ]
    ],

];
