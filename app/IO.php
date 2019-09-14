<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IO extends Model 
{

    protected $table = 'item_order';
    public $timestamps = true;
    protected $fillable = array('item_id', 'order_id', 'price', 'quantity', 'notes');

}