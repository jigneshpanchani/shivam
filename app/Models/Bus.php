<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    protected $fillable =[
        'bus_number',
        'balance',
        'owner_name',
        'root',
        'type',
        'seat',
        'fuel_capacity',
        'note'
    ];
    use SoftDeletes;

    public function work(){
        return $this->hasMany(Work::class);
    }
}
