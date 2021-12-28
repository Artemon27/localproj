<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Rooms;

class RoomPersons extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'user_id', 'main','name_staff','name_post','pager','pechat','mobile'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function room(): BelongsTo
    {
        return $this->belongsTo(Rooms::class);
    }
    
}
