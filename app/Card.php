<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model 
{

    protected $table = 'cards';
    public $timestamps = true;
    protected $fillable = array('order_id', 'client_id', 'total_summation', 'item_id', 'price', 'quantity');

}