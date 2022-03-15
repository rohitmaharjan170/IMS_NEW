<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function stockLogs(){
        return $this->belongsTo('App\StockLog');
    }
}
