<?php
namespace App\Repositories\SQL;

use App\Models\Color;
use App\Repositories\Contract\ColorRepositoryInterface;

class ColorRepository extends BaseRepository implements ColorRepositoryInterface
{
    protected $color;

    public function __construct(Color $color){
        parent::__construct($color);
        $this->color = $color;
    }
    
}