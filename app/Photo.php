<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $timestamps = FALSE;

    public function Product(){
        return $this->belongsTo('App\Product','product_id');
    }
}
