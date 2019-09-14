<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model 
{

    protected $table = 'regions';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id', 'restaurant_id');
    public function city()
    {
        return $this->belongsTo('App\City');
    }
    public function restaurants()
    {
        return $this->hasMany('App\Restaurant');
    }

}