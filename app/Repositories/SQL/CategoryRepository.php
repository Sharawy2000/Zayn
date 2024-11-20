<?php
namespace App\Repositories\SQL;

use App\Models\Category;
use App\Repositories\Contract\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    protected $category;

    public function __construct(Category $category){
        parent::__construct($category);
        $this->category = $category;
    }
    
}