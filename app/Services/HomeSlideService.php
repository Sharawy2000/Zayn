<?php 
namespace App\Services;

use App\Repositories\Contract\HomeSlideRepositoryInterface;
use App\Traits\Helper;

class HomeSlideService extends BaseService
{
    use Helper;
    protected $homeSlideRepository;

    public function __construct(HomeSlideRepositoryInterface $homeSlideRepository){
        parent::__construct($homeSlideRepository);
        $this->homeSlideRepository=$homeSlideRepository;
    }

    public function createSlide($data){
        $slide = $this->store($data);
        $image_path = $this->uploadImage($data['image'],'uploads/home-slides/images');
        $this->homeSlideRepository->updateColumnValue($slide,'image',$image_path);
        return $slide;
    }
    public function updateSlide($id,$data){ 
        $slide = $this->get($id);
        $oldPathImage= $slide->image;
        $slide = $this->update($data,$id);

        if(isset($data['image'])){
            unlink($oldPathImage);
            $image_path = $this->uploadImage($data['image'],'uploads/home-slides/images');
            $this->homeSlideRepository->updateColumnValue($slide,'image',$image_path);
        }

        return $slide;

    }
    public function deleteSlide($id){
        $slide = $this->get($id);
        unlink($slide->image);
        $this->delete($id);
    }
}