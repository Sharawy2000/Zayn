<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model 
{

    protected $table = 'cart_items';
    public $timestamps = true;
    protected $fillable = array('cart_id', 'product_id', 'color_id', 'size_id', 'quantity','price_adjustment');

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function color()
    {
        return $this->belongsTo('App\Models\Color');
    }

    public function size()
    {
        return $this->belongsTo('App\Models\Size');
    }

}