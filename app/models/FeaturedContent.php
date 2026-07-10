<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class FeaturedContent extends Model
{
    protected string $table = 'featured_content';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'item_type', 'item_id', 'section', 'sort_order', 'label',
        'start_date', 'end_date'
    ];
}
