<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Log extends Model
{
    protected $fillable =[
        'action',
        'note',
        'data',
        'user_id'
    ];

    public function addLog($data, $action, $note){
        $logArr = array(
            'action'    => $action,
            'data'      => json_encode($data),
            'note'      => $note,
            'user_id'   => Auth::user()->id
        );
        return DB::table('logs')->insert($logArr);
    }
}
