<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class Country extends Model
{
    protected string $table = 'countries';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name', 'slug', 'code', 'continent', 'status'];
}
