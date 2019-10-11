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
        'note',
        'fitness',
        'insurance'
    ];
    use SoftDeletes;

    public function work(){
        return $this->hasMany(Work::class);
    }
    public function expense(){
        return $this->hasMany(Expense::class);
    }
    public function income(){
        return $this->hasMany(Income::class);
    }
}
