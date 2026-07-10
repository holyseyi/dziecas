<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Advertisement extends Model
{
    protected string $table = 'advertisements';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'name', 'position', 'code', 'image', 'url', 'alt_text', 'width',
        'height', 'status', 'start_date', 'end_date', 'click_count', 'impression_count', 'created_by'
    ];
}
