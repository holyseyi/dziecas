<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/php_errors.log');

require_once __DIR__ . '/../config/config.php';
$config = require __DIR__ . '/../config/config.php';

if (file_exists(__DIR__ . '/../config/wasmer.php')) {
    $wasmerConfig = require __DIR__ . '/../config/wasmer.php';
    $config = array_merge($config, $wasmerConfig);
}

foreach ($config as $key => $value) {
    if (!defined($key)) {
        define($key, $value);
    }
}

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/App.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../core/DatabaseSessionHandler.php';
require_once __DIR__ . '/../helpers/functions.php';

$sessionPdo = new \PDO('sqlite:' . (defined('DB_PATH') ? DB_PATH : __DIR__ . '/../database/database.sqlite'));
$sessionPdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$sessionPdo->exec('PRAGMA journal_mode = WAL');
$sessionPdo->exec('PRAGMA busy_timeout = 5000');
$handler = new \Core\DatabaseSessionHandler($sessionPdo);
session_set_save_handler($handler, true);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

// Simple autoloader
spl_autoload_register(function ($class) {
    $prefixes = [
        'Controllers\\' => __DIR__ . '/../app/controllers/',
        'Models\\' => __DIR__ . '/../app/models/',
        'Helpers\\' => __DIR__ . '/../app/helpers/',
        'Middleware\\' => __DIR__ . '/../app/middleware/',
        'Api\\' => __DIR__ . '/../app/controllers/Api/',
        'Controllers\\Admin\\' => __DIR__ . '/../app/controllers/Admin/',
        'Core\\' => __DIR__ . '/../core/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (str_starts_with($class, $prefix)) {
            $relativeClass = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
});

use Core\App;
use Core\Router;

try {
    $app = App::getInstance();
    $router = new Router();
    require_once __DIR__ . '/../routes/web.php';
    $app->run();
} catch (\Throwable $e) {
    http_response_code(500);
    if (defined('APP_DEBUG') && APP_DEBUG) {
        echo '<h1>Application Error</h1>';
        echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
        echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    } else {
        echo '<h1>500 Internal Server Error</h1>';
        error_log($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    }
}
