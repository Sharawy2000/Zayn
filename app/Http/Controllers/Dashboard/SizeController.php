<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\SizeService;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    protected $sizeService;
    public function __construct(SizeService $sizeService){
        $this->sizeService = $sizeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        if($request->search){

            $sizes = $this->sizeService->modelFilter($request->search,5);
        }else{
            $sizes = $this->sizeService->all(5);

        }
        return view('dashboard.sizes.index',compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:50'
        ]);

        $this->sizeService->store($data);

        return back()->with('success','Successfully size created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $size = $this->sizeService->get($id);
        return view('dashboard.sizes.show',compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $size = $this->sizeService->get($id);
        return view('dashboard.sizes.edit',compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string|max:50'
        ]);

        $this->sizeService->update($data,$id);

        return back()->with('success','Successfully size updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->sizeService->delete($id);
        return back()->with('success','Successfully size deleted');

    }
}
