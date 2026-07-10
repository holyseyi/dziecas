<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class WatchHistory extends Model
{
    protected string $table = 'watch_history';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'user_id', 'item_type', 'item_id', 'episode_id', 'progress', 'duration'
    ];
}
