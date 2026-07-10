<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Comment extends Model
{
    protected string $table = 'comments';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'item_type', 'item_id', 'user_id', 'parent_id', 'author_name',
        'author_email', 'content', 'status', 'ip_address', 'user_agent'
    ];
}
