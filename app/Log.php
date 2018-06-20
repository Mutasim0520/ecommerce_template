<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    public function Order(){
        return $this->belongsTo('App\Order');
    }
    public function admin(){
        return $this->belongsTo('App\Admin');
    }
}
