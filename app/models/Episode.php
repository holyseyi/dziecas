<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Episode extends Model
{
    protected string $table = 'episodes';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'series_id', 'season', 'episode_number', 'title', 'description',
        'duration', 'air_date', 'view_count', 'download_count', 'like_count',
        'imdb_rating', 'thumbnail', 'video_url', 'status', 'published_at'
    ];
}
