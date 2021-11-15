<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Holidesign extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id','odd', 'even', 'odd_holi', 'even_holi', 'odd_color', 'even_color', 'odd_holi_color', 'even_holi_color', 'base_color',
        'background', 'chosen_color', 'chosen_dop_color', 'card_header', 'carousel_controls'
    ];
    
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
