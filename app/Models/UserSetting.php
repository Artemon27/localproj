<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;
    
      protected $fillable = [
        'design',
    ];
      
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
