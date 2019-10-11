<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable =[
        'work_id',
        'expense_id',
        'amount',
        'detail',
        'work_date'
    ];
    public function work(){
        return $this->belongsTo(Work::class);
    }
}
