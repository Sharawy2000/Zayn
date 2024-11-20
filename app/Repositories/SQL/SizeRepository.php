<?php
namespace App\Repositories\SQL;

use App\Models\Size;
use App\Repositories\Contract\SizeRepositoryInterface;

class SizeRepository extends BaseRepository implements SizeRepositoryInterface
{
    protected $size;

    public function __construct(Size $size){
        parent::__construct($size);
        $this->size = $size;
    }
    
}