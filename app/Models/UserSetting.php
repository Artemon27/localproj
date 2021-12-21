<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;
    
      protected $fillable = [
        'design',
        'user_id',
    ];
      
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
