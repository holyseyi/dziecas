<?php

declare(strict_types=1);

if (php_sapi_name() !== 'cli' && php_sapi_name() !== 'phpdbg') {
    die('This script can only be run from CLI.');
}

echo "=========================================\n";
echo "  MovieHub Installation Script\n";
echo "=========================================\n\n";

$baseDir = __DIR__;
$dbPath = $baseDir . '/database/database.sqlite';
$schemaPath = $baseDir . '/database/schema.sql';
$seedsPath = $baseDir . '/database/seeds.sql';

if (file_exists($dbPath)) {
    echo "[INFO] Database already exists. Remove it to reinstall.\n";
    exit(1);
}

try {
    echo "[1/4] Creating database directory...\n";
    $dbDir = dirname($dbPath);
    if (!is_dir($dbDir)) {
        mkdir($dbDir, 0755, true);
    }

    echo "[2/4] Creating SQLite database file...\n";
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    echo "       Database created successfully.\n";

    echo "[3/4] Running schema installation...\n";
    $schema = file_get_contents($schemaPath);
    $queries = array_filter(array_map('trim', explode(';', $schema)));
    foreach ($queries as $query) {
        if (!empty($query)) {
            try {
                $db->exec($query);
            } catch (PDOException $e) {
                echo "       Warning: " . $e->getMessage() . "\n";
            }
        }
    }
    echo "       Schema installed successfully.\n";

    echo "[4/4] Running seed data...\n";
    $seeds = file_get_contents($seedsPath);
    $queries = array_filter(array_map('trim', explode(';', $seeds)));
    foreach ($queries as $query) {
        if (!empty($query)) {
            try {
                $db->exec($query);
            } catch (PDOException $e) {
                echo "       Warning: " . $e->getMessage() . "\n";
            }
        }
    }
    echo "       Seed data inserted successfully.\n";

    echo "\n=========================================\n";
    echo "  Installation Complete!\n";
    echo "=========================================\n";
echo "Default Admin Login:\n";
echo "  Email:    ddadzie124@gmail.com\n";
echo "  Password: admin123\n";
    echo "  URL:      http://localhost/admin\n";
    echo "=========================================\n\n";

    $db = null;
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
