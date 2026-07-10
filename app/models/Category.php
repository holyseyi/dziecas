<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Category extends Model
{
    protected string $table = 'categories';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'name', 'slug', 'description', 'icon', 'color', 'status', 'sort_order',
        'meta_title', 'meta_description'
    ];
}
