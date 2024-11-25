<?php 
namespace App\Services;

use App\Repositories\Contract\ColorRepositoryInterface;

class ColorService extends BaseService
{
    protected $colorRepository;

    public function __construct(ColorRepositoryInterface $colorRepository){
        parent::__construct($colorRepository);
        $this->colorRepository=$colorRepository;
    }

    
    
    
}