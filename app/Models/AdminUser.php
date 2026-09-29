<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_users';

    protected $fillable = ['name', 'email', 'password', 'is_active', 'last_login_at', 'must_change_password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'is_active'             => 'boolean',
        'must_change_password'  => 'boolean',
        'last_login_at'         => 'datetime',
    ];
}
