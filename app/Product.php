<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // By defualt the table name is the plural form of model name
    // But we can change the TABLE NAME as
    protected $table = 'products'; //I'm keeping as it is
    //Primary key
    public $primaryKey = 'id'; //Keeping the same
    //Timestamps (To have the timestamps)
    public $timeStamps = true; //It's actually true by default, its not necessary to write this

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function order(){
        return $this->belongsTo('App\Order');
    }

    public function stockLogs(){
        return $this->belongsTo('App\StockLog');
    }

    public function purchases(){
        return $this->belongsTo('App\Purchase');
    }

    public function rate(){
        return $this->belongsTo(Client::class);
    }

    public function client(){
        return $this->belongsTo('App\Client');
    }
}
