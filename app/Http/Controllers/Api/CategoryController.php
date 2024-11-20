<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use Helper;
    protected $categoryService;

    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cats = $this->categoryService->all(5);
        return $this->responseJson('categories',$cats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'image'=>'required|file|mimes:png,jpg,jpeg,gif'
        ]);

        $cat = $this->categoryService->createCategory($data);

        return $this->responseJson('Successfully category created',$cat,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cat = $this->categoryService->get($id);
        return $this->responseJson('category',$cat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data=$request->validate([
            'name'=>'nullable|string',
            'description'=>'nullable|string',
            'image'=>'nullable|file|mimes:png,jpg,jpeg,gif'
        ]);

        $cat = $this->categoryService->updateCategory($id,$data);

        return $this->responseJson('Successfully category updated',$cat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categoryService->deleteCategory($id);
        return $this->responseJson('Category updated',null);

    }
}
