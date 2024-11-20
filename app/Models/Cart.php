<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model 
{

    protected $table = 'carts';
    public $timestamps = true;
    protected $fillable = array('customer_id', 'price', 'price_after_offer');

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function items()
    {
        return $this->hasMany('App\Models\CartItem');
    }

}