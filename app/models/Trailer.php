<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Trailer extends Model
{
    protected string $table = 'trailers';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'movie_id', 'series_id', 'title', 'url', 'thumbnail', 'duration', 'provider', 'sort_order'
    ];
}
