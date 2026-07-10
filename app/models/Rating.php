<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Rating extends Model
{
    protected string $table = 'ratings';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'item_type', 'item_id', 'user_id', 'rating', 'ip_address', 'user_agent'
    ];
}
