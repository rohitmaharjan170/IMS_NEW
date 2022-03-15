<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function order(){
        return $this->belongsTo('App\Order');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function bill(){
        return $this->hasMany('Bill');
    }

    // public function payment(){
    //     return $this->hasMany('App\Payment');
    // }

    public function rate(){
        return $this->hasMany('App\Rate');
    }

    public function product(){
        return $this->hasMany('App\Client');
    }
}
