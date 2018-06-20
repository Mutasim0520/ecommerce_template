<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_catagorie extends Model
{
    public $timestamps = FALSE;

    public function item(){
        return $this->hasMany('App\Catagories_item');
    }

    public function Catagorie(){
        return $this->belongsTo('App\Catagorie');
    }

    public function product(){
        return $this->hasMany('App\Product');
    }

    public function simple_belongs(){
        return $this->hasMany('App\Simpe_index_belong');
    }
}
