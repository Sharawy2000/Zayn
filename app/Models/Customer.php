<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable 
{
    use HasApiTokens;
    

    protected $table = 'customers';
    public $timestamps = true;
    protected $fillable = array('name','phone', 'email', 'password', 'neighborhood_id');

    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function neighborhood()
    {
        return $this->belongsTo('App\Models\Neighborhood');
    }

    public function favorites()
    {
        return $this->belongsToMany('App\Models\Product');
    }
    public function offers()
    {
        return $this->belongsToMany('App\Models\Offer');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function cart(){
        return $this->hasOne('App\Models\Cart');
    }

}