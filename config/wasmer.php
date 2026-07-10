<?php

declare(strict_types=1);

// Wasmer-specific configuration
// This file is included when running on Wasmer edge runtime

if (!defined('APP_ENV')) {
    define('APP_ENV', getenv('APP_ENV') ?: 'production');
}

if (!defined('APP_DEBUG')) {
    define('APP_DEBUG', getenv('APP_DEBUG') === 'true');
}

if (!defined('APP_URL')) {
    define('APP_URL', getenv('APP_URL') ?: 'https://dziecar.wasmer.app');
}

// Disable maintenance mode on Wasmer
define('MAINTENANCE_MODE', false);

// Configure database path for Wasmer
// Use /tmp for writable database in ephemeral Wasmer containers
define('DB_PATH', getenv('DB_PATH') ?: '/tmp/moviehub.sqlite');

// Use /tmp for all writable storage in Wasmer
define('STORAGE_PATH', '/tmp/storage/');
define('CACHE_PATH', '/tmp/cache/');
define('UPLOADS_PATH', '/tmp/storage/uploads/');

// Ensure required directories exist in /tmp
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

// Initialize database if it doesn't exist
if (!file_exists(DB_PATH)) {
    try {
        $db = new PDO('sqlite:' . DB_PATH);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
        if ($schema) {
            $queries = array_filter(array_map('trim', explode(';', $schema)));
            foreach ($queries as $query) {
                if (!empty($query)) {
                    try {
                        $db->exec($query);
                    } catch (PDOException $e) {
                        // Ignore duplicate table errors
                    }
                }
            }
        }

        $seeds = file_get_contents(__DIR__ . '/../database/seeds.sql');
        if ($seeds) {
            $queries = array_filter(array_map('trim', explode(';', $seeds)));
            foreach ($queries as $query) {
                if (!empty($query)) {
                    try {
                        $db->exec($query);
                    } catch (PDOException $e) {
                        // Ignore duplicate key errors
                    }
                }
            }
        }
    } catch (PDOException $e) {
        error_log('Database initialization failed: ' . $e->getMessage());
    }
}

// Override config values for Wasmer
return [
    'APP_ENV' => APP_ENV,
    'APP_DEBUG' => APP_DEBUG,
    'APP_URL' => APP_URL,
    'DB_PATH' => DB_PATH,
    'STORAGE_PATH' => STORAGE_PATH,
    'CACHE_PATH' => CACHE_PATH,
    'UPLOAD_MAX_SIZE' => 50 * 1024 * 1024,
    'UPLOAD_ALLOWED_TYPES' => [
        'image/jpeg', 'image/png', 'image/gif', 'image/webp',
        'video/mp4', 'video/webm',
    ],
];
