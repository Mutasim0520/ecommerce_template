<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders_product extends Model
{
    public $timestamps = FALSE;

    public function order(){
        return $this->belongsTo('App\Order');
    }
}
