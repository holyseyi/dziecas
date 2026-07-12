<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $config = require __DIR__ . '/../config/config.php';
        $driver = defined('DB_DRIVER') ? DB_DRIVER : ($config['DB_DRIVER'] ?? 'sqlite');
        $path = defined('DB_PATH') ? DB_PATH : ($config['DB_PATH'] ?? __DIR__ . '/../database/database.sqlite');

        try {
            $dsn = "sqlite:" . $path;

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $this->pdo = new PDO($dsn, null, null, $options);

            $this->pdo->exec('PRAGMA journal_mode = WAL');
            $this->pdo->exec('PRAGMA busy_timeout = 5000');
            $this->pdo->exec('PRAGMA synchronous = NORMAL');
            $this->pdo->exec('PRAGMA cache_size = -64000');
            $this->pdo->exec('PRAGMA temp_store = MEMORY');

            $this->pdo->exec('PRAGMA foreign_keys = ON');

            $this->initializeIfNeeded();
        } catch (PDOException $e) {
            throw new PDOException("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Ensure the application schema (and seed data) exist. This keeps the app
     * working on read-only/ephemeral deployments (e.g. Wasmer Edge) where the
     * database file may be created fresh and not pre-seeded by the bootstrap.
     */
    private function initializeIfNeeded(): void
    {
        error_log('DB init: users=' . ($this->tableExists('users') ? '1' : '0') . ' media=' . ($this->tableExists('media') ? '1' : '0'));
        try {
            if ($this->tableExists('users')) {
                $this->ensureMediaTable();
                $this->dropFeaturedContentFk();
                error_log('DB init: ran migrations');
                return;
            }
        } catch (\Throwable $e) {
            error_log('DB init error: ' . $e->getMessage());
            // Unable to inspect the schema; attempt initialization below.
        }

        $this->runSqlFile(__DIR__ . '/../database/schema.sql');
        $this->runSqlFile(__DIR__ . '/../database/seeds.sql');
    }

    /**
     * Create the media table on existing deployments that were bootstrapped
     * before it was added (self-init only runs when the users table is absent).
     */
    private function ensureMediaTable(): void
    {
        if ($this->tableExists('media')) {
            return;
        }
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS media (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                type VARCHAR(20) NOT NULL,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                file_path VARCHAR(255) NOT NULL,
                thumbnail VARCHAR(255),
                duration INTEGER DEFAULT 0,
                status VARCHAR(20) DEFAULT 'active',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )"
        );
    }

    /**
     * The featured_content.item_id originally had a FOREIGN KEY to movies(id),
     * which wrongly rejected series and media items. Rebuild the table without
     * that constraint so any content type can be featured on the home page.
     */
    private function dropFeaturedContentFk(): void
    {
        $fks = $this->pdo->query("PRAGMA foreign_key_list(featured_content)")->fetchAll(\PDO::FETCH_ASSOC);
        $hasMoviesFk = false;
        foreach ($fks as $fk) {
            if (($fk['table'] ?? '') === 'movies') {
                $hasMoviesFk = true;
                break;
            }
        }
        if (!$hasMoviesFk) {
            return;
        }

        $this->pdo->exec('PRAGMA foreign_keys = OFF');
        $this->pdo->exec('DROP TABLE IF EXISTS featured_content_old');
        $this->pdo->exec('ALTER TABLE featured_content RENAME TO featured_content_old');
        $this->pdo->exec(
            "CREATE TABLE featured_content (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                item_type VARCHAR(20) NOT NULL,
                item_id INTEGER NOT NULL,
                section VARCHAR(100) NOT NULL,
                sort_order INTEGER DEFAULT 0,
                label VARCHAR(255),
                start_date DATETIME,
                end_date DATETIME,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )"
        );
        $this->pdo->exec(
            "INSERT INTO featured_content (id, item_type, item_id, section, sort_order, label, start_date, end_date, created_at)
             SELECT id, item_type, item_id, section, sort_order, label, start_date, end_date, created_at FROM featured_content_old"
        );
        $this->pdo->exec('DROP TABLE featured_content_old');
        $this->pdo->exec('PRAGMA foreign_keys = ON');
    }

    private function runSqlFile(string $path): void
    {
        if (!file_exists($path)) {
            return;
        }
        $sql = file_get_contents($path);
        if ($sql === false || $sql === '') {
            return;
        }
        foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
            if ($statement === '') {
                continue;
            }
            try {
                $this->pdo->exec($statement);
            } catch (\Throwable $e) {
                error_log('Database init warning: ' . $e->getMessage());
            }
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function query(string $sql, array $params = []): \PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException("Query failed: " . $e->getMessage() . " | SQL: " . $sql);
        }
    }

    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetchColumn(string $sql, array $params = [], int $column = 0): mixed
    {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetchColumn($column);
        return $result !== false ? $result : null;
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    public function rowCount(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollback(): bool
    {
        return $this->pdo->rollBack();
    }

    public function tableExists(string $table): bool
    {
        $stmt = $this->query("SELECT name FROM sqlite_master WHERE type='table' AND name = ?", [$table]);
        return $stmt->rowCount() > 0;
    }

    public function getTables(): array
    {
        $stmt = $this->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
        $tables = [];
        while ($row = $stmt->fetch()) {
            $tables[] = $row['name'];
        }
        return $tables;
    }
}
