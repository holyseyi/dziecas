<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Language extends Model
{
    protected string $table = 'languages';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name', 'slug', 'code', 'status'];
}
