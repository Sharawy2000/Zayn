<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model 
{

    protected $table = 'images';
    public $timestamps = true;
    protected $fillable = array('product_id', 'url');

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

}