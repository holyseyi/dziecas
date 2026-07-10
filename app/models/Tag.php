<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Tag extends Model
{
    protected string $table = 'tags';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name', 'slug', 'status'];
}
