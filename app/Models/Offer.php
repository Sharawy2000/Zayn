<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'discount', 'date_begin', 'date_end');

    public function customers(){
        return $this->belongsToMany('App\Models\Customer');
    }

}