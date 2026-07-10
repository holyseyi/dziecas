<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Director extends Model
{
    protected string $table = 'directors';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'name', 'slug', 'biography', 'image', 'birth_date', 'birth_place',
        'nationality', 'status'
    ];
}
