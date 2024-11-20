<?php
namespace App\Repositories\SQL;

use App\Models\Offer;
use App\Repositories\Contract\OfferRepositoryInterface;

class OfferRepository extends BaseRepository implements OfferRepositoryInterface
{
    protected $offer;

    public function __construct(Offer $offer){
        parent::__construct($offer);
        $this->offer = $offer;
    }
    
}