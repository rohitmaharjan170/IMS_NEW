<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function stock_logs(){
        return $this->hasMany('App\StockLog');
    }

    public function purchases(){
        return $this->hasMany('App\Purchase');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function clients(){
        return $this->hasMany('App\Client');
    }

    public function payments(){
        return $this->hasMany('App\Payment');
    }

    public function settings(){
        return $this->hasMany('App\Setting');
    }
}
