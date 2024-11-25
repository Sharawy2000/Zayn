<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{    
    protected $colorService;
    public function __construct(ColorService $colorService){
        $this->colorService = $colorService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = $this->colorService->all(5);
        return view('dashboard.colors.index',compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:50'
        ]);

        $this->colorService->store($data);

        return back()->with('success','Successfully color created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $color = $this->colorService->get($id);
        return view('dashboard.colors.show',compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $color = $this->colorService->get($id);
        return view('dashboard.colors.edit',compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string|max:50'
        ]);

        $this->colorService->update($data,$id);

        return back()->with('success','Successfully color updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->colorService->delete($id);
        return back()->with('success','Successfully color deleted');

    }
}
