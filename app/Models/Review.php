<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model 
{

    protected $table = 'reviews';
    public $timestamps = true;
    protected $fillable = array('comment', 'rate', 'customer_id', 'product_id');

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

}