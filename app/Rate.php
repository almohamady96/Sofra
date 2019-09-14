<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model 
{

    protected $table = 'rates';
    public $timestamps = true;
    protected $fillable = array('client_id', 'restaurant_id', 'comment', 'rate');

}