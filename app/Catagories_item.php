<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catagories_item extends Model
{
    public $timestamps = FALSE;

    public function Catagorie(){
        return $this->belongsTo('App\Catagorie');
    }
    public function Sub_catagorie(){
        return $this->belongsTo('App\Sub_catagorie');
    }

    public function product(){
        return $this->hasMany('App\Product');
    }
}
