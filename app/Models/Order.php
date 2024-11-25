<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('customer_id', 'total_price', 'payment_method_id','price_after_offer','shipping_fees', 'status');

    protected $casts =[
        'status'=>OrderStatus::class
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity','price_at_order','color_id','size_id');
    }

}