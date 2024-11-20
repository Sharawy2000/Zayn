<?php 
namespace App\Services;

use App\Repositories\Contract\OfferRepositoryInterface;

class OfferService extends BaseService
{
    protected $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository){
        parent::__construct($offerRepository);
        $this->offerRepository=$offerRepository;
    }

    
    
    
}