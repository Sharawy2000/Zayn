<?php
namespace App\Repositories\SQL;

use App\Models\City;
use App\Repositories\Contract\CityRepositoryInterface;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    protected $city;

    public function __construct(City $city){
        parent::__construct($city);
        $this->city = $city;
    }
    
}