<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->search){
            
            $categories = $this->categoryService->modelFilter($request->search,5);
        }else{
            $categories = $this->categoryService->all(5);

        }
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
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

        $this->categoryService->createCategory($data);

        return back()->with('success','Successfully category created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->get($id);
        return view('dashboard.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->categoryService->get($id);
        return view('dashboard.categories.edit',compact('category'));
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

        $this->categoryService->updateCategory($id,$data);

        return back()->with('success','Successfully category updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categoryService->delete($id);
        return back()->with('success','Successfully category deleted');

    }
}
