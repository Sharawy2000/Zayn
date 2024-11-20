<?php 
namespace App\Services;

use App\Repositories\Contract\ColorRepositoryInterface;
use App\Repositories\Contract\ImageRepositoryInterface;
use App\Repositories\Contract\ProductRepositoryInterface;
use App\Repositories\Contract\SizeRepositoryInterface;
use App\Traits\Helper;

class ProductService extends BaseService
{
    use Helper;
    protected $productRepository;
    protected $imageRepository;
    protected $colorRepository;
    protected $sizeRepository;

    public function __construct(ProductRepositoryInterface $productRepository ,
     ImageRepositoryInterface $imageRepository,
     ColorRepositoryInterface $colorRepository,
     SizeRepositoryInterface $sizeRepository){
        parent::__construct($productRepository);
        $this->productRepository = $productRepository;
        $this->imageRepository = $imageRepository;
        $this->colorRepository = $colorRepository;
        $this->sizeRepository= $sizeRepository;
    }
    public function createProduct($data){
        $product = $this->store($data);

        foreach($data['images'] as $image){     
            $img_path = $this->uploadImage($image,"uploads/products/images");
            $this->imageRepository->attachImages($product,$img_path);
        }
        foreach($data['colors'] as $index => $colorID){
            $colorPriceAdjustment=$data['colors_price_adjustment'][$index] ?? 0;
            $this->productRepository->attach($product,'colors',$colorID,['price_adjustment'=>$colorPriceAdjustment]);
        };
        foreach($data['sizes'] as $index => $sizeID){
            $sizePriceAdjustment=$data['sizes_price_adjustment'][$index] ?? 0;
            $this->productRepository->attach($product,'sizes',$sizeID,['price_adjustment'=>$sizePriceAdjustment]);
        }

        return $product;
    }
    public function updateProduct($data,$id){
        $product = $this->update($data,$id);
        $productImages=$this->productRepository->getRelationData($product,'images');

        if(isset($data['images'])){
            foreach($productImages as $image){
                unlink($image->url);
                $this->imageRepository->remove($image->id);
            }
            foreach($data['images'] as $image){     
                $img_path = $this->uploadImage($image,"uploads/products/images");
                $this->imageRepository->attachImages($product,$img_path);
            }
        }

        if(isset($data['colors'])){
            foreach($data['colors'] as $index => $colorID){
                $colorPriceAdjustment=$data['colors_price_adjustment'][$index] ?? 0;
                $colorUpdatedData[$colorID]=['price_adjustment'=>$colorPriceAdjustment];
                $this->productRepository->sync($product,'colors',$colorUpdatedData);
            }
        }

        if(isset($data['sizes'])){
            foreach($data['sizes'] as $index => $sizeID){
                $sizePriceAdjustment=$data['sizes_price_adjustment'][$index] ?? 0;
                $sizeUpdatedData[$sizeID]=['price_adjustment'=>$sizePriceAdjustment];
                $this->productRepository->sync($product,'sizes',$sizeUpdatedData);
            }
        }
        
        return $product;
    }
    public function deleteProduct($id){
        $product = $this->get($id);
        $productImages=$this->productRepository->getRelationData($product,'images');
        foreach ($productImages as $image){
            unlink($image->url);
        }

        $this->delete($id);
    }
}