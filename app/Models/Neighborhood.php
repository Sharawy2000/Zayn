<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model 
{
    use HasFactory;

    protected $table = 'neighborhoods';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id');

    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }

}