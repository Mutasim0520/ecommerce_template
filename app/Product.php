<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    public $timestamps = FALSE;

    public function Photo(){
        return $this->hasMany('App\Photo','product_id');
    }
    public function Price(){
        return $this->hasMany('App\Price');
    }
    public function Size(){
        return $this->hasMany('App\Size');
    }
    public function Color(){
        return $this->hasMany('App\Color');
    }
    public function users_wishlst(){
        return $this->belongsTo('App\Users_wishlst');
    }

    public function catgory(){
        return $this->belongsTo('App\Catagorie');
    }

    public function sub_catgory(){
        return $this->belongsTo('App\Sub_catagorie');
    }

    public function catgory_item(){
        return $this->belongsTo('App\Catagories_item');
    }

    public function browsed_product(){
        return $this->hasMany('App\Browsed_product');
    }

    public function tag(){
        return $this->belongsToMany('App\Tag');
    }

    public function order(){
        return $this->belongsToMany('App\Order');
    }

}
