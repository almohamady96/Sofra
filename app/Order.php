<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'status', 'address', 'cost','delivery_cost','net','commission', 'total', 'delivered_at', 'price', 'note', 'payment_id','payment_way');

    public function items()
    {
        return $this->belongsToMany('App\Item')->withPivot('price','quantity','note');
    }

    public function cards()
    {
        return $this->hasMany('App\Card');
    }
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }





}