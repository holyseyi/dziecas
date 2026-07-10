<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Announcement extends Model
{
    protected string $table = 'announcements';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'title', 'content', 'type', 'position', 'status', 'start_date',
        'end_date', 'priority', 'created_by'
    ];
}
