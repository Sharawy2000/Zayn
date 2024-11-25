<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable=array('title', 'description','customer_id');

    public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }
}
