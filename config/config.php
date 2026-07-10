<?php

declare(strict_types=1);

return [
    'APP_NAME' => getenv('APP_NAME') ?: 'MovieHub',
    'APP_URL' => getenv('APP_URL') ?: 'http://localhost',
    'APP_ENV' => getenv('APP_ENV') ?: 'development',
    'APP_DEBUG' => getenv('APP_DEBUG') === 'true',
    'APP_TIMEZONE' => getenv('APP_TIMEZONE') ?: 'UTC',
    'APP_LANG' => getenv('APP_LANG') ?: 'en',
    'APP_THEME' => getenv('APP_THEME') ?: 'dark',

    'DB_DRIVER' => getenv('DB_DRIVER') ?: 'sqlite',
    'DB_PATH' => getenv('DB_PATH') ?: __DIR__ . '/../database/database.sqlite',

    'UPLOAD_MAX_SIZE' => 50 * 1024 * 1024,
    'UPLOAD_ALLOWED_TYPES' => [
        'image/jpeg', 'image/png', 'image/gif', 'image/webp',
        'video/mp4', 'video/webm',
        'application/pdf',
        'text/plain'
    ],

    'PAGINATION_LIMIT' => 20,
    'TRENDING_DAYS' => 7,
    'CACHE_TTL' => 3600,

    'CSRF_TOKEN_LIFETIME' => 7200,
    'LOGIN_RATE_LIMIT' => 5,
    'LOGIN_RATE_LIMIT_WINDOW' => 300,

    'MAINTENANCE_MODE' => false,

    'SEO_META_TITLE' => 'MovieHub - Watch Latest Movies & TV Series',
    'SEO_META_DESCRIPTION' => 'Watch the latest movies, TV series, anime, and more. High quality streaming and downloads.',
    'SEO_KEYWORDS' => 'movies, tv series, streaming, download, watch online',
    'SEO_CANONICAL' => '',

    'SOCIAL_FACEBOOK' => '',
    'SOCIAL_TWITTER' => '',
    'SOCIAL_INSTAGRAM' => '',
    'SOCIAL_YOUTUBE' => '',

    'EMAIL_FROM' => 'noreply@moviehub.com',
    'EMAIL_FROM_NAME' => 'MovieHub',

    'PER_PAGE' => 20,
    'ITEMS_PER_ROW' => 6,
];
