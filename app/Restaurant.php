<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model 
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'region_id', 'email', 'password', 'status', 'min_price', 'delivery_cost', 'phone', 'whatsapp', 'image', 'api_token', 'pin_code', 'delivery_way');
    protected $hidden=array('password','api_token');
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function offers()
    {
        return $this->hasMany('App\Offer');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function tokens()
    {
        return $this->morphMany('App\Token', 'accountable');
    }
    public function items()
    {
        return $this->hasMany('App\Item');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function rates()
    {
        return $this->hasMany('App\Rate');
    }

    public function notifications()
    {
        return $this->morphMany('App\Notification', 'notifiable');
    }
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

}