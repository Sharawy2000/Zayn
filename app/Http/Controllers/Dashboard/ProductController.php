<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService){
        $this->productService=$productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->all(5);
        return view('dashboard.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create');
        
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
            'colors.*'=>'required|exists:colors,id',
            'colors_price_adjustment'=>'nullable|array',
            'colors_price_adjustment.*'=>'required|integer',
            'sizes'=>'required|array',
            'sizes.*'=>'required|exists:sizes,id',
            'sizes_price_adjustment'=>'nullable|array',
            'sizes_price_adjustment.*'=>'required|integer',

        ]);

        $this->productService->createProduct($data);

        return back()->with('success','Successfully product created');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->get($id);
        return view('dashboard.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->productService->get($id);
        return view('dashboard.products.edit',compact('product'));
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
            'images.*'=>'nullable|mimes:jpg,jpeg,gif,png',
            'colors'=>'nullable|array',
            'colors.*'=>'nullable|exists:colors,id',
            'colors_price_adjustment'=>'nullable|array',
            'colors_price_adjustment.*'=>'nullable',
            'sizes'=>'nullable|array',
            'sizes.*'=>'nullable|exists:sizes,id',
            'sizes_price_adjustment'=>'nullable|array',
            'sizes_price_adjustment.*'=>'nullable',

        ]);

        $this->productService->updateProduct($data,$id);

        return back()->with('success','Successfully product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->deleteProduct($id);
        return back()->with('success','Successfully product deleted');

        
    }
}
