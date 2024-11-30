<?php 
namespace App\Services;

use App\Repositories\Contract\ReviewRepositoryInterface;

class ReviewService extends BaseService
{
    protected $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository){
        parent::__construct($reviewRepository);
        $this->reviewRepository=$reviewRepository;
    }
    public function reviewCreate($data,$isWeb=null){
        if($isWeb){
            $data['customer_id']=auth()->guard('web-customer')->user()->id;
        }else{
            $data['customer_id']=auth()->guard('api-customer')->user()->id;
        }
        $review =$this->reviewRepository->store($data);

        return $review;
    }
    
}