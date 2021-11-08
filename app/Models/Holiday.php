<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Holiday extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'datefrom', 'dateto', 'days', 'allow', 'PVT', 'INV', 'OB'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
