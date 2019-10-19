<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable =[
        'partner_id',
        'date',
        'credit',
        'debit',
        'note'
    ];

    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}
