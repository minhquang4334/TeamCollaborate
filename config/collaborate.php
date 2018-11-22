<?php

return [

    // Mail Notification
    'mail_notification' => env('MAIL_NOTIFICATION') ?: false,

    'collaborate_title' => 'Team Collaborate',

    // Default Avatar
    'default_avatar' => env('DEFAULT_AVATAR') ?: '/images/logo.jpg',

    // Default Icon
    'default_icon' => env('DEFAULT_ICON') ?: '/images/logo.jpg',

    // Color Theme
    'color_theme' => 'default-theme',

    // Meta
    'meta' => [
        'keywords' => 'Team Collaborate, Team chat app',
        'description' => 'a place where your team comes together to collaborate, important information can be found by the right people, and your tools pipe in information when and where you need it.
'
    ],

    // Social Share
    'social_share' => [
        'article_share'    => env('ARTICLE_SHARE') ?: true,
        'discussion_share' => env('DISCUSSION_SHARE') ?: true,
        'sites'            => env('SOCIAL_SHARE_SITES') ?: 'google,twitter,weibo',
        'mobile_sites'     => env('SOCIAL_SHARE_MOBILE_SITES') ?: 'google,twitter,weibo,qq,wechat',
    ],

    // Google Analytics
    'google' => [
        'id'   => env('GOOGLE_ANALYTICS_ID', 'Google-Analytics-ID'),
        'open' => env('GOOGLE_OPEN') ?: false
    ],

    // Discussion Page
    'discussion' => [
        'number' => 20,
        'sort'   => 'desc',
        'sortColumn' => 'created_at',
    ],

    // Footer
    'footer' => [
        'github' => [
            'open' => true,
            'url'  => 'https://github.com/minhquang4334',
        ],
        'twitter' => [
            'open' => true,
            'url'  => 'https://twitter.com/minhquang4334'
        ],
        'meta' => 'Qlog created at 2018',
    ],

    'license' => '<br/>This article is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>.',

];
