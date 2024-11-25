<?php 
namespace App\Services;

use App\Repositories\Contract\SizeRepositoryInterface;

class SizeService extends BaseService
{
    protected $sizeRepository;

    public function __construct(SizeRepositoryInterface $sizeRepository){
        parent::__construct($sizeRepository);
        $this->sizeRepository=$sizeRepository;
    }

    
    
    
}