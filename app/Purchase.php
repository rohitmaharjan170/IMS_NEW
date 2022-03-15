<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function product(){
        return $this->hasMany('App\Product');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    // public function log(){
    //     return $this->belongsTo('App\Log');
    // }
}
