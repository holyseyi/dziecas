<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

class User extends Model
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'username', 'email', 'password_hash', 'role_id', 'avatar', 'bio',
        'country', 'language', 'timezone', 'email_verified_at', 'last_login_at',
        'last_login_ip', 'status', 'reset_token', 'reset_expires_at', 'notification_preferences'
    ];
}
