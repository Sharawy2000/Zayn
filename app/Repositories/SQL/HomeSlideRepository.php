<?php
namespace App\Repositories\SQL;

use App\Models\HomeSlide;
use App\Repositories\Contract\HomeSlideRepositoryInterface;

class HomeSlideRepository extends BaseRepository implements HomeSlideRepositoryInterface
{
    protected $homeSlide;

    public function __construct(HomeSlide $homeSlide){
        parent::__construct($homeSlide);
        $this->homeSlide = $homeSlide;
    }
    
}