<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable =[
        'bus_number',
        'owner_name',
        'root',
        'type',
        'seat',
        'fuel_capacity',
        'note'
    ];

    public function work(){
        return $this->hasMany(Work::class);
    }
}
