<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Bookmark extends Model
{
    protected string $table = 'bookmarks';
    protected string $primaryKey = 'id';
    protected array $fillable = ['user_id', 'item_type', 'item_id'];
}
