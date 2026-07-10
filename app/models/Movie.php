<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Movie extends Model
{
    protected string $table = 'movies';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'title', 'original_title', 'slug', 'description', 'short_description',
        'poster', 'banner', 'trailer_url', 'duration', 'release_date',
        'imdb_rating', 'user_rating', 'rating_count', 'view_count',
        'download_count', 'like_count', 'comment_count', 'bookmark_count',
        'type', 'category_id', 'country_id', 'language_id', 'director_id',
        'status', 'published_at', 'featured', 'trending', 'editor_pick',
        'quality', 'is_adult', 'seo_title', 'seo_description', 'seo_keywords',
        'canonical_url', 'json_ld', 'created_by', 'updated_by'
    ];
}
