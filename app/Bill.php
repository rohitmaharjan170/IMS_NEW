<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function order(){
        return $this->hasMany('App\Order');
    }

    public function client()
    {
        return $this->belongsTo('Client', 'id');
    }
}
