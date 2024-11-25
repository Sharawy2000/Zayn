<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'category_id', 'description', 'price');

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function sizes()
    {
        return $this->belongsToMany('App\Models\Size')->withPivot('price_adjustment');
    }

    public function colors()
    {
        return $this->belongsToMany('App\Models\Color')->withPivot('price_adjustment');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function favorites()
    {
        return $this->belongsToMany('App\Models\Customer');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order')->withPivot('quantity','price_at_order','color_id','size_id');
    }

}