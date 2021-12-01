<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPersons extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'user_id', 'main'
    ];
}
