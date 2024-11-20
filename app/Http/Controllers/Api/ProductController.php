<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use Helper;
    protected $productService;
    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->all(5);
        return $this->responseJson('products',$products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'category_id'=>'required|integer|exists:categories,id',
            'price'=>'required|string',
            'images'=>'required|array',
            'images.*'=>'required|mimes:jpg,jpeg,gif,png',
            'colors'=>'required|array',
            'colors.*'=>'required|integer|exists:colors,id',
            'colors_price_adjustment'=>'nullable|array',
            'sizes'=>'required|array',
            'sizes.*'=>'required|integer|exists:sizes,id',
            'sizes_price_adjustment'=>'nullable|array',

        ]);
        $product = $this->productService->createProduct($data);
        return $this->responseJson('successfully created',$product,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->get($id);
        return $this->responseJson('product',$product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string',
            'description'=>'nullable|string',
            'category_id'=>'nullable|integer|exists:categories,id',
            'price'=>'nullable|string',
            'images'=>'nullable|array',
            'images.*'=>'required|mimes:jpg,jpeg,gif,png',
            'colors'=>'nullable|array',
            'colors.*'=>'required|integer|exists:colors,id',
            'colors_price_adjustment'=>'nullable|array',
            'sizes'=>'nullable|array',
            'sizes.*'=>'required|integer|exists:sizes,id',
            'sizes_price_adjustment'=>'nullable|array',

        ]);
        $product = $this->productService->updateProduct($data,$id);
        return $this->responseJson('successfully updated',$product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->deleteProduct($id);
        return $this->responseJson('successfully deleted');
        
    }
}
