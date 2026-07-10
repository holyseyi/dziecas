<?php

declare(strict_types=1);

namespace Core;

use Core\Database;

class Model
{
    protected Database $db;
    protected string $table = '';
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];
    protected array $casts = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(string $orderBy = 'id DESC', int $limit = 0, int $offset = 0): array
    {
        $sql = "SELECT * FROM {$this->table}" . ($orderBy ? " ORDER BY {$orderBy}" : '') . ($limit > 0 ? " LIMIT {$limit}" : '') . ($offset > 0 ? " OFFSET {$offset}" : '');

        return $this->db->fetchAll($sql);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        return $this->db->fetch($sql, ['id' => $id]);
    }

    public function findBy(string $column, mixed $value): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
        return $this->db->fetch($sql, ['value' => $value]);
    }

    public function where(string $column, mixed $value, string $operator = '=', string $orderBy = '', int $limit = 0): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} :value" . ($orderBy ? " ORDER BY {$orderBy}" : '') . ($limit > 0 ? " LIMIT {$limit}" : '');

        return $this->db->fetchAll($sql, ['value' => $value]);
    }

    public function create(array $data): string|int
    {
        $data = $this->filterFillable($data);
        if (empty($data)) {
            throw new \InvalidArgumentException('No fillable data provided');
        }

        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);
        $set = implode(', ', $columns);
        $params = implode(', ', $placeholders);

        $sql = "INSERT INTO {$this->table} ({$set}) VALUES ({$params})";
        $this->db->query($sql, array_combine($placeholders, array_values($data)));

        return $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);
        if (empty($data)) {
            return false;
        }

        $set = implode(', ', array_map(fn($col) => "{$col} = :{$col}", array_keys($data)));
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = :id";

        $params = array_merge($data, ['id' => $id]);
        return $this->db->query($sql, $params)->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        return $this->db->query($sql, ['id' => $id])->rowCount() > 0;
    }

    public function count(string $where = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}" . ($where ? " WHERE {$where}" : '');
        $result = $this->db->fetch($sql, $params);
        return (int)($result['total'] ?? 0);
    }

    public function paginate(int $page = 1, int $perPage = 20, string $orderBy = 'id DESC', ?string $where = null, array $params = []): array
    {
        $offset = ($page - 1) * $perPage;
        $total = $this->count($where ?? '', $params);

        $sql = "SELECT * FROM {$this->table}" . ($where ? " WHERE {$where}" : '') . " ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}";
        $items = $this->db->fetchAll($sql, $params);

        return [
            'items'      => $items,
            'total'      => $total,
            'page'       => $page,
            'per_page'   => $perPage,
            'total_pages' => (int)ceil($total / $perPage)
        ];
    }

    private function filterFillable(array $data): array
    {
        if (empty($this->fillable)) {
            return $data;
        }
        return array_intersect_key($data, array_flip($this->fillable));
    }

    protected function cast(mixed $value, string $type): mixed
    {
        return match ($type) {
            'int'    => (int)$value,
            'float'  => (float)$value,
            'bool'   => (bool)$value,
            'array'  => is_string($value) ? json_decode($value, true) : $value,
            'json'   => is_string($value) ? json_decode($value, true) : $value,
            default  => $value
        };
    }
}
