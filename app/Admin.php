<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders_discussion(){
        return $this->hasMany('App\Orders_discussion');
    }

    public function order(){
        return $this->belongsToMany('App\Order');
    }

    public function ticket(){
        return $this->hasMany('App\Ticket');
    }

    public function request(){
        return $this->hasMany('App\Request');
    }
}
