<?php

declare(strict_types=1);

namespace Core;

/**
 * Database-backed session handler.
 *
 * Stores session data in the application's SQLite database instead of the
 * filesystem. On edge deployments (e.g. Wasmer Edge) the default file-based
 * session save path (/tmp) is not guaranteed to persist between requests,
 * which caused authenticated users to be bounced back to the login page.
 * Persisting sessions in the database keeps authentication working across
 * requests and instances that share the same database volume.
 */
class DatabaseSessionHandler implements \SessionHandlerInterface
{
    private \PDO $pdo;
    private string $table = 'sessions';

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function open(string $path, string $name): bool
    {
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS {$this->table} (
                id VARCHAR(128) PRIMARY KEY,
                data TEXT,
                last_activity INTEGER
            )"
        );
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read(string $id): string
    {
        $stmt = $this->pdo->prepare("SELECT data FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (string)$row['data'] : '';
    }

    public function write(string $id, string $data): bool
    {
        $this->pdo->prepare(
            "INSERT INTO {$this->table} (id, data, last_activity) VALUES (?, ?, ?)
             ON CONFLICT(id) DO UPDATE SET data = excluded.data, last_activity = excluded.last_activity"
        )->execute([$id, $data, time()]);
        return true;
    }

    public function destroy(string $id): bool
    {
        $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?")->execute([$id]);
        return true;
    }

    public function gc(int $max_lifetime): int
    {
        $this->pdo->prepare("DELETE FROM {$this->table} WHERE last_activity < ?")
            ->execute([time() - $max_lifetime]);
        return 0;
    }
}
