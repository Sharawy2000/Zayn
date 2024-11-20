<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlide extends Model 
{

    protected $table = 'home_slides';
    public $timestamps = true;
    protected $fillable = array('title', 'description', 'image', 'alt_text', 'order');

}