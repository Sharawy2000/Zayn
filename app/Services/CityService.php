<?php 
namespace App\Services;

use App\Repositories\Contract\CityRepositoryInterface;

class CityService extends BaseService
{
    protected $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository){
        parent::__construct($cityRepository);
        $this->cityRepository=$cityRepository;
    }

    
    
    
}