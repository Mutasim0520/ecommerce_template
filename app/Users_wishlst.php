<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_wishlst extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function product(){
        return $this->hasMany('App\Product');
    }
}
