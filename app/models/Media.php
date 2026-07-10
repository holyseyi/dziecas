<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Media extends Model
{
    protected string $table = 'media';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'type', 'title', 'description', 'file_path', 'thumbnail', 'duration', 'status',
    ];
}
