<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'client_id',
        'product_id',
        'client_rate',
    ];

    public function rate(){
        return $this->belongsTo('App\Client');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
