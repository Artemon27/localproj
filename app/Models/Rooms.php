<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\RoomPersons;

class Rooms extends Model
{
    use HasFactory;

    protected $fillable = [
        'otdel', 'penal', 'corpus_room', 'phone','imp','id_corp','id_room','responsible'
    ];
    
    public function roomPersons()
    {
        return $this->hasMany(RoomPersons::class);
    }
}
