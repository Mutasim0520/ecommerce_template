<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simple_index extends Model
{
    public $timestamps = FALSE;
    protected $table = 'simple_indexs';

    public function simple_belongs(){
        return $this->hasMany('App\Simpe_index_belong');
    }

}
