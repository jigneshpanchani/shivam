<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    protected $fillable =[
        'department',
        'balance',
        'name',
        'salary',
        'contact_no',
        'aadhar_card_no',
        'address',
        'note'
    ];

    use SoftDeletes;

    public function salary(){ //salaries
        return $this->hasMany(Salary::class);
    }
}
