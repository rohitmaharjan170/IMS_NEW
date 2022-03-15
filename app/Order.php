<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'type',
        'order_date',
        'client_name',
        'product_name',
        'sale_quantity',
        'rate',
        'sub_amount',
        'discount',
        'grand_total',
        'paid_amount',
        'due_amount'
    ]; 

    public function client(){
        return $this->hasMany('App\Client');
    }

    public function product(){
        return $this->hasMany('App\Product');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    // public function setEntryDateAttribute($input)
    // {
    //     $this->attributes['order_date'] = 
    //     Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
    // }

    // public function getEntryDateAttribute($input)
    // {
    //     return Carbon::createFromFormat('Y-m-d', $input)
    //     ->format(config('app.date_format'));
    // }

    public function bills(){
        return $this->belongsTo('App\Bill');
    }
}
