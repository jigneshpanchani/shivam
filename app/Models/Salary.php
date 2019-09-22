<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable =[
        'staff_id',
        'amount',
        'date',
        'created_by'
    ];

    public function staff(){
        return $this->belongsTo(Staff::class);
    }
}
