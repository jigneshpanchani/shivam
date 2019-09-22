<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable =[
        'department',
        'name',
        'salary',
        'contact_no',
        'aadhar_card_no',
        'address',
        'note'
    ];

    public function salary(){ //salaries
        return $this->hasMany(Salary::class);
    }
}
