<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Series extends Model
{
    protected string $table = 'series';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'title', 'original_title', 'slug', 'description', 'short_description',
        'poster', 'banner', 'trailer_url', 'total_seasons', 'total_episodes',
        'status', 'release_date', 'end_date', 'imdb_rating', 'user_rating',
        'rating_count', 'view_count', 'download_count', 'like_count',
        'comment_count', 'bookmark_count', 'category_id', 'country_id',
        'language_id', 'director_id', 'published_at', 'featured', 'trending',
        'editor_pick', 'quality', 'is_adult', 'seo_title', 'seo_description',
        'seo_keywords', 'canonical_url', 'json_ld', 'created_by', 'updated_by'
    ];
}
