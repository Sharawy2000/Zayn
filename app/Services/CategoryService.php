<?php 
namespace App\Services;

use App\Repositories\Contract\CategoryRepositoryInterface;
use App\Traits\Helper;

class CategoryService extends BaseService 
{
    use Helper;
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository){
        parent::__construct($categoryRepository);
        $this->categoryRepository = $categoryRepository;
    }
    public function createCategory($data){
        $cat = $this->store($data);
        $image_path = $this->uploadImage($data['image'],'uploads/categories/images');
        $this->categoryRepository->updateColumnValue($cat,'image',$image_path);
        return $cat;
    }
    public function updateCategory($id,$data){ 
        $cat = $this->get($id);
        $oldPathImage= $cat->image;
        $cat = $this->update($data,$id);

        if(isset($data['image'])){
            unlink($oldPathImage);
            $image_path = $this->uploadImage($data['image'],'uploads/categories/images');
            $this->categoryRepository->updateColumnValue($cat,'image',$image_path);
        }

        return $cat;

    }
    public function deleteCategory($id){
        $cat = $this->get($id);
        unlink($cat->image);
        $this->delete($id);
    }
}