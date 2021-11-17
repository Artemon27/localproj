<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'value',
    ];
    
    public function CentralYear() {
        $value = Setting::Where('option','=','centralYear')->first()->value;
        return $value;
    }
    
    public function CurrentYear() {
        return Setting::Where('option','=','curYear')->first()->value;
    }
}
