<?php
namespace App\Repositories\SQL;

use App\Models\Review;
use App\Repositories\Contract\ReviewRepositoryInterface;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    protected $review;

    public function __construct(Review $review){
        parent::__construct($review);
        $this->review = $review;
    }
    
}