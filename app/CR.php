<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CR extends Model 
{

    protected $table = 'category_restaurant';
    public $timestamps = true;
    protected $fillable = array('category_id', 'restaurant_id');

}