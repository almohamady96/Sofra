<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model 
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'city_id', 'region_id', 'description', 'password', 'image', 'api_token', 'pin_code');
    protected $hidden = array('api_token', 'pin_code');



    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function rates()
    {
        return $this->hasMany('App\Rate');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function cart()
    {
        return $this->belongsToMany('App\Item','cards')->withPivot('price', 'quantity', 'notes','id');
    }

    public function tokens()
    {
        return $this->morphMany('App\Token', 'accountable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Notification', 'notifiable');
    }

}