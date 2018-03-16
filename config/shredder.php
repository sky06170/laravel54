<?php


return [
    /**
     * Facebook app id
     */
    'app_id' => env('JUKSY_FB_ID'),
    /**
     * Facebook app secret key
     */
    'app_secret' => env('JUKSY_FB_SECRET'),
    /**
     * Facebook graph api version
     */
    'default_graph_version' => 'v2.9',
    /**
     * Request permissions
     */
    'permissions' => ['email', 'user_likes', 'manage_pages', 'publish_pages', 'pages_manage_instant_articles'],
];
