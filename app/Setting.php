<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'vendor_name',
        'address',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
