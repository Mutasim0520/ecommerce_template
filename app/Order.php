<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    public function order_product(){
        return $this-> hasMany('App\Orders_product');
    }
    public function user(){
        return $this-> belongsTo('App\User');
    }

    public function order_discussion(){
        return $this->hasMany('App\Orders_discussion');
    }

    public function log(){
        return $this->hasMany('App\Log');
    }

    public function admin(){
        return $this->belongsToMany('App\Admin');
    }

     public function product(){
        return $this->belongsToMany('App\Product');
    }
}
