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
        try {
            if ($this->tableExists('users')) {
                return;
            }
        } catch (\Throwable $e) {
            // Unable to inspect the schema; attempt initialization below.
        }

        $this->runSqlFile(__DIR__ . '/../database/schema.sql');
        $this->runSqlFile(__DIR__ . '/../database/seeds.sql');
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
