<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model 
{
    use HasFactory;
    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name', 'country_id');

    public function neighborhoods()
    {
        return $this->hasMany('App\Models\Neighborhood');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

}