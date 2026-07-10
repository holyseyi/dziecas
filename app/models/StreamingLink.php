<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class StreamingLink extends Model
{
    protected string $table = 'streaming_links';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'movie_id', 'episode_id', 'title', 'url', 'quality', 'format',
        'language', 'is_working', 'reported_count', 'click_count'
    ];
}
