<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable =[
        'work_id',
        'amount',
        'detail',
        'work_date'
    ];
}
