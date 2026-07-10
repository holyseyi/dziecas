<?php

declare(strict_types=1);

// Wasmer-specific bootstrap

$isWasmer = getenv('APP_ENV') === 'production';

if ($isWasmer) {
    define('DB_PATH', getenv('DB_PATH') ?: '/tmp/moviehub.sqlite');
    define('STORAGE_PATH', '/tmp/storage/');
    define('CACHE_PATH', '/tmp/cache/');
    define('UPLOADS_PATH', '/tmp/storage/uploads/');
    if (!empty(getenv('APP_URL'))) {
        define('APP_URL', getenv('APP_URL'));
    }
}

if (!defined('DB_PATH')) {
    define('DB_PATH', __DIR__ . '/../database/database.sqlite');
}
if (!defined('STORAGE_PATH')) {
    define('STORAGE_PATH', __DIR__ . '/../storage/');
}
if (!defined('CACHE_PATH')) {
    define('CACHE_PATH', __DIR__ . '/../cache/');
}
if (!defined('UPLOADS_PATH')) {
    define('UPLOADS_PATH', __DIR__ . '/../storage/uploads/');
}

$requiredDirs = [
    '/tmp',
    '/tmp/storage',
    '/tmp/storage/uploads',
    '/tmp/storage/uploads/posters',
    '/tmp/storage/uploads/banners',
    '/tmp/storage/uploads/screenshots',
    '/tmp/storage/uploads/trailers',
    '/tmp/storage/uploads/avatars',
    '/tmp/cache',
    '/tmp/logs',
];

foreach ($requiredDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

if (!file_exists(DB_PATH)) {
    try {
        $db = new PDO('sqlite:' . DB_PATH);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $schemaPath = __DIR__ . '/../database/schema.sql';
        if (file_exists($schemaPath)) {
            $schema = file_get_contents($schemaPath);
            if ($schema) {
                $queries = array_filter(array_map('trim', explode(';', $schema)));
                foreach ($queries as $query) {
                    if (!empty($query)) {
                        try {
                            $db->exec($query);
                        } catch (\Throwable $e) {
                            error_log('Schema init error: ' . $e->getMessage());
                        }
                    }
                }
            }
        }

        $seedsPath = __DIR__ . '/../database/seeds.sql';
        if (file_exists($seedsPath)) {
            $seeds = file_get_contents($seedsPath);
            if ($seeds) {
                $queries = array_filter(array_map('trim', explode(';', $seeds)));
                foreach ($queries as $query) {
                    if (!empty($query)) {
                        try {
                            $db->exec($query);
                        } catch (\Throwable $e) {
                            error_log('Seed init error: ' . $e->getMessage());
                        }
                    }
                }
            }
        }
    } catch (\Throwable $e) {
        error_log('Database initialization failed: ' . $e->getMessage());
    }
}

// Verify tables exist and attempt recovery if missing
try {
    $check = new PDO('sqlite:' . DB_PATH);
    $check->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $tables = $check->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('movies', $tables)) {
        error_log('movies table missing after init, attempting recovery...');
        $schemaPath = __DIR__ . '/../database/schema.sql';
        if (file_exists($schemaPath)) {
            $schema = file_get_contents($schemaPath);
            if ($schema) {
                $queries = array_filter(array_map('trim', explode(';', $schema)));
                foreach ($queries as $query) {
                    if (!empty($query)) {
                        try {
                            $check->exec($query);
                        } catch (\Throwable $e) {
                            error_log('Recovery error: ' . $e->getMessage());
                        }
                    }
                }
            }
        }
    }
} catch (\Throwable $e) {
    error_log('Table verification failed: ' . $e->getMessage());
}
