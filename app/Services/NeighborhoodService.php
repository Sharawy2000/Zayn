<?php 
namespace App\Services;

use App\Repositories\Contract\NeighborhoodRepositoryInterface;

class NeighborhoodService extends BaseService
{
    protected $neighborhoodRepository;

    public function __construct(NeighborhoodRepositoryInterface $neighborhoodRepository){
        parent::__construct($neighborhoodRepository);
        $this->neighborhoodRepository=$neighborhoodRepository;
    }

    
    
    
}