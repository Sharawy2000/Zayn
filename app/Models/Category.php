<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model 
{
    use HasFactory;

    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'image');

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

}