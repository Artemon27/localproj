<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Holiday;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ULTRA_ADMIN = 10;
    const ROLE_ADMIN = 9;
    const ROLE_USER = 1;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function roleAsString(): string
    {
        switch ($this->role) {
            case self::ROLE_ADMIN:
                return "Админ";
            default:
                return "Пользователь";
        }
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeRoleUser(Builder $query): Builder
    {
        return $query->where('role', self::ROLE_USER);
    }
    
    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }
}
