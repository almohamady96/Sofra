<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'restaurant_sales_cost', 'pay_off', 'remaning','notes');

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
