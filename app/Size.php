<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    public $timestamps = FALSE;

    public function Product(){
        return $this->belongsTo('App\Product');
    }
}
