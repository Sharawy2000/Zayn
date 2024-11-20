<?php
namespace App\Repositories\SQL;

use App\Models\Image;
use App\Repositories\Contract\ImageRepositoryInterface;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    protected $image;

    public function __construct(Image $image){
        parent::__construct($image);
        $this->image = $image;
    }

    public function attachImages($model,$image){
        return $model->images()->create(['url'=>$image]);
    }
    
}