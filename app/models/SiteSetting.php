<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class SiteSetting extends Model
{
    protected string $table = 'site_settings';
    protected string $primaryKey = 'id';
    protected array $fillable = ['key', 'value', 'type', 'group', 'is_public'];
}
