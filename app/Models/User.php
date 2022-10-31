<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'activation_key',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public static $createRules = [
        'name' => 'required|max:120',
        'email' => 'required|unique:users|max:320|email',
    ];
    public static $updateRules = [
        'name' => 'required|max:120',
    ];

    public static $setPasswordRules = [
        'password' => 'regex:"^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"',
    ];
}
