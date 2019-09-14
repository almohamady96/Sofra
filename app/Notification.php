<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title', 'content', 'title_en','content_en','notifiable_id', 'notifiable_type','client_id','order_id');


    public function notifiable()
    {
        return $this->morphTo();
    }

}