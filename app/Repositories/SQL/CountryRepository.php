<?php
namespace App\Repositories\SQL;

use App\Models\Country;
use App\Repositories\Contract\CountryRepositoryInterface;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    protected $country;

    public function __construct(Country $country){
        parent::__construct($country);
        $this->country = $country;
    }
    
}