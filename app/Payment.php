<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // public function client(){
    //     return $this->belongsTo('App\Client');
    // }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
