<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Genre extends Model
{
    protected string $table = 'genres';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name', 'slug', 'description', 'image', 'status', 'sort_order'];
}
