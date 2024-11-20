<?php
namespace App\Repositories\SQL;

use App\Models\Product;
use App\Repositories\Contract\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $product;

    public function __construct(Product $product){
        parent::__construct($product);
        $this->product=$product;
    }

    
    
}