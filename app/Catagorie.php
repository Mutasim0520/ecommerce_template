<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catagorie extends Model
{
    public function sub(){
        return $this->hasMany('App\Sub_catagorie');
    }

    public function item(){
        return $this->hasMany('App\Catagories_item');
    }

    public function product(){
        return $this->hasMany('App\Product');
    }

    public function simple_belongs(){
        return $this->hasMany('App\Simpe_index_belong');
    }

}
