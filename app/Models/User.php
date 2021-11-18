<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Holiday;

use App\Models\Holidesign;
use App\Models\UserSetting;
use App\Models\off_hours;
use Carbon\Carbon;

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
        'objectguid', 'pager', 'department', 'sAMAccountName'
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

    function shortName () {
        $format="A b. c.";
        $words = explode(" ", $this->name);
        $format_keys = array("A", "B", "C");
        $short_name = $format;
        foreach ($format_keys as $index => $word) {
            $short_name = str_replace($word, $words[$index], $short_name);
            $short_name = str_replace(mb_strtolower($word), mb_substr($words[$index], 0, 1, 'UTF-8'), $short_name);
        }
        return $short_name;
    }

    public function scopeRoleUser(Builder $query): Builder
    {
        return $query->where('role', self::ROLE_USER);
    }

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    public function off_hours()
    {
        return $this->hasMany(off_hours::class);
    }

    public function holidaysYear($year)
    {
        $dateFrom = Carbon::create($year, 1, 1, 0, 0, 0);

        $dateTo = Carbon::create($year, 12, 31, 23, 59, 59);

        return $this->holidays->Where('datefrom','>',$dateFrom)->Where('datefrom','<',$dateTo);
    }
    public function colors()
    {
        return $this->hasOne(Holidesign::class);
    }
    
    public function design() {
        dd($this->settings());
        return $this->settings()->design;
        
    }
    
    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function offHoursDate($date)
    {
      $date = $date." 00:00:00";

        return $this->off_hours->Where('date','=',$date);
    }}
