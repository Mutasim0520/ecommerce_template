<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simpe_index_belong extends Model
{
   public $timestamps = FALSE;
   protected $table = 'simpe_index_belongs';

   public function simple_index(){
       return $this->belongsTo('App\Simple_index');
   }

    public function sub_catagory(){
        return $this->belongsTo('App\Sub_catagory');
    }

    public function catagory(){
        return $this->belongsTo('App\Catagory');
    }
}

