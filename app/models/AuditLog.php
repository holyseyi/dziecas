<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class AuditLog extends Model
{
    protected string $table = 'audit_logs';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'user_id', 'action', 'entity_type', 'entity_id', 'old_values',
        'new_values', 'ip_address', 'user_agent'
    ];
}
