<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account_detail extends Model
{
    protected $fillable =[
        'account_id',
        'bus_id',
        'type',
        'amount',
        'detail',
        'date'
    ];
}
