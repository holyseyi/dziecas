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
define('DB_PATH', __DIR__ . '/../database/database.sqlite');

// Configure storage paths
define('STORAGE_PATH', __DIR__ . '/../storage/');
define('CACHE_PATH', __DIR__ . '/../cache/');
define('UPLOADS_PATH', __DIR__ . '/../storage/uploads/');

// Wasmer-specific optimizations
if (APP_ENV === 'production') {
    ini_set('display_errors', '0');
    error_reporting(E_ERROR | E_PARSE);
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

// Ensure required directories exist
$requiredDirs = [
    __DIR__ . '/../database',
    __DIR__ . '/../storage',
    __DIR__ . '/../storage/uploads',
    __DIR__ . '/../storage/uploads/posters',
    __DIR__ . '/../storage/uploads/banners',
    __DIR__ . '/../storage/uploads/screenshots',
    __DIR__ . '/../storage/uploads/trailers',
    __DIR__ . '/../storage/uploads/avatars',
    __DIR__ . '/../cache',
    __DIR__ . '/../logs',
];

foreach ($requiredDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
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
    } catch (PDOException $e) {
        error_log('Database initialization failed: ' . $e->getMessage());
    }
}

return [
    'APP_ENV' => APP_ENV,
    'APP_DEBUG' => APP_DEBUG,
    'APP_URL' => APP_URL,
    'DB_PATH' => DB_PATH,
];
