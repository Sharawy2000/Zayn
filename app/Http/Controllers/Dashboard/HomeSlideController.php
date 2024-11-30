<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\HomeSlideService;
use Illuminate\Http\Request;

class HomeSlideController extends Controller
{
    protected $homeSlideService;
    public function __construct(HomeSlideService $homeSlideService){
        $this->homeSlideService = $homeSlideService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->search){
            
            $slides = $this->homeSlideService->modelFilter($request->search,5);
        }else{
            $slides = $this->homeSlideService->all(5);

        }
        return view('dashboard.home-slides.index',compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.home-slides.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'title'=>'required|string',
            'description'=>'required|string',
            'image'=>'required|file|mimes:png,jpg,jpeg,gif,webp',
            'order'=>'nullable|integer',
        ]);

        $this->homeSlideService->createSlide($data);

        return back()->with('success','Successfully slide created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slide = $this->homeSlideService->get($id);
        return view('dashboard.home-slides.show',compact('slide'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slide = $this->homeSlideService->get($id);
        return view('dashboard.home-slides.edit',compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data=$request->validate([
            'title'=>'nullable|string',
            'description'=>'nullable|string',
            'image'=>'nullable|file|mimes:png,jpg,jpeg,gif,webp',
            'order'=>'nullable|integer',

        ]);

        $this->homeSlideService->updateslide($id,$data);

        return back()->with('success','Successfully slide updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->homeSlideService->delete($id);
        return back()->with('success','Successfully slide deleted');

    }
}
