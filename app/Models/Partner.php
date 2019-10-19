<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable =[
        'name',
        'contact_no',
        'bus_ids',
        'address',
        'note'
    ];
}
