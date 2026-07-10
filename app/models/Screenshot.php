<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Screenshot extends Model
{
    protected string $table = 'screenshots';
    protected string $primaryKey = 'id';
    protected array $fillable = ['movie_id', 'series_id', 'image', 'caption', 'sort_order'];
}
