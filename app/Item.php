<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model 
{

    protected $table = 'items';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'name', 'price', 'description', 'image', 'prepare_time','disabled');

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    public function cards()
    {
        return $this->hasMany('App\Card');
    }
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
    protected $hidden = ['disabled'];


}