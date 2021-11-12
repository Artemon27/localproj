<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class off_hours extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'date', 'prpsk', 'room', 'phone', 'allow'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
