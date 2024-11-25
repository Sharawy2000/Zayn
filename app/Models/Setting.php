<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // protected $fillable=array();
    protected $guarded=array('created_at', 'updated_at');

}
