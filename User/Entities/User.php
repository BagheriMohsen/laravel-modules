<?php

namespace Modules\User\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $email
 * @property string $mobile
 * @property mixed $name
 * @property mixed $cellphone
 */
class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes;

    protected $fillable = [
        'referral_id',
        'name',
        'email',
        'bio',
        'cellphone',
        'cellphone_verified_at',
        'national_code',
        'national_code_verified_at',
        'postal_code',
        'address',
        'email_verified_at',
        'is_staff',
        'is_superuser',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static array $registerRule = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', 'password'],
    ];

    public static array $loginRule = [
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ];
}
