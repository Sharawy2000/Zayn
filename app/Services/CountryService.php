<?php 
namespace App\Services;

use App\Repositories\Contract\CountryRepositoryInterface;

class CountryService extends BaseService
{
    protected $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository){
        parent::__construct($countryRepository);
        $this->countryRepository=$countryRepository;
    }

    
    
    
}