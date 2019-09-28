<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable =[
        'bus_id',
        'work_date',
        'income',
        'expense',
        'note'
    ];

    public function incomes(){
        return $this->hasMany(Income::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function bus(){
        return $this->belongsTo(Bus::class);
    }
}
