<?php

return [

    "title" => [
        "default" => "ホーム",
        "404" => "ページが見つかりません",
        "comics" => "漫画",
        "comic" => ":title - 漫画",
        "reader" => ":title を読む",
        "characters" => "キャラクター",
        "character" => ":name - キャラクター",
        "artists" => "アーティスト",
        "artist" => ":name - アーティスト",
        "authors" => "著者",
        "Author" => ":name - 著者",
        "groups" => "グループ",
        "group" => ":name - グループ",
        "parodies" => "パロディ",
        "parody" => ":name - パロディ",
        "relationships" => "関係",
        "relationship" => ":name - 関係",
        "tags" => "タグ",
        "tag" => ":name - タグ",
        "language" => ":name - 言語",
        "category" => ":name - カテゴリー",
        "profile" => ":username - プロフィール",
        "settings" => "設定",
        "admin" => [
            "publishers" => "出版社の管理",
            "authors" => "著者の管理",
            "artists" => "アーティストの管理",
            "genres" => "ジャンルの管理",
            "comics" => "漫画の管理",
            "slides" => "スライドの管理",
        ]
    ],
    "description" => [
        "default" => config('site.name')." は無料で頻繁に更新される、複数言語に対応した漫画と同人誌のリーダーで、数千の漫画を読んでダウンロードできます。",
        "tags" => config('site.name')." で無修正、ロリコン、フルカラー、大きな胸、熟女などの漫画を読みましょう。これは漫画と同人誌のリーダーです。",
        "comic" => ":date - :creators による :title、カテゴリ :category の無料ダウンロードと読み取りが ".config('site.name')." で可能です。",
        "artist" => ":name による :count 件の漫画を ".config('site.name')." で読みましょう。",
        "author" => ":name による :count 件の漫画を ".config('site.name')." で読みましょう。",
        "group" => ":description",
        "parody" => ":count 件の :name パロディ漫画を ".config('site.name')." で読みましょう。",
        "relationship" => ":count 件の :name 関係の漫画を ".config('site.name')." で読みましょう。",
        "category" => ":count 件の :name カテゴリの漫画を ".config('site.name')." で読みましょう。",
        "tag" => ":count 件の :name タグの漫画を ".config('site.name')." で読みましょう。",
        "character" => ":count 件の :name キャラクターの漫画を ".config('site.name')." で読みましょう。",
        "language" => ":count 件の :name 言語の漫画を ".config('site.name')." で読みましょう。",
        "reader" => "",
        "defaults" => [
            "category" => "漫画",
            "creators" => "複数のアーティスト"
        ]
    ],

];
