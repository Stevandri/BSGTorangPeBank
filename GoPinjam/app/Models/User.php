<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <- tambahkan ini
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
         'name',
        'email',
        'password',
        'username',         // Tambahkan ini
        'position',         // Tambahkan ini
        'phone_number',     // Tambahkan ini
        'role',             // Pastikan ini juga ada
    ];
}
