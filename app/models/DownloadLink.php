<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class DownloadLink extends Model
{
    protected string $table = 'download_links';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'movie_id', 'episode_id', 'title', 'url', 'quality', 'file_size',
        'format', 'language', 'subtitles', 'is_working', 'reported_count', 'click_count'
    ];
}
