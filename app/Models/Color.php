<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model 
{
    use HasFactory;

    protected $table = 'colors';
    public $timestamps = true;
    protected $fillable = array('name');

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('price_adjustment');
    }

}