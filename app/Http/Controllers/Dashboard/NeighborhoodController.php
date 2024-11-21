<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\NeighborhoodService;
use Illuminate\Http\Request;

class NeighborhoodController extends Controller
{
    protected $neighborhoodService;
    public function __construct(NeighborhoodService $neighborhoodService){
        $this->neighborhoodService = $neighborhoodService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $neighborhoods = $this->neighborhoodService->all(5);
        return view('dashboard.neighborhoods.index',compact('neighborhoods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.neighborhoods.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:80',
            'city_id'=>'required|integer|exists:cities,id',
            'country_id'=>'required|integer|exists:countries,id',
        ]);

        $this->neighborhoodService->store($data);

        return back()->with('success','Successfully neighborhood created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $neighborhood = $this->neighborhoodService->get($id);
        return view('dashboard.neighborhoods.show',compact('neighborhood'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $neighborhood = $this->neighborhoodService->get($id);
        return view('dashboard.neighborhoods.edit',compact('neighborhood'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string|max:80',
            'city_id'=>'nullable|integer|exists:cities,id',
            'country_id'=>'nullable|integer|exists:countries,id',

        ]);

        $this->neighborhoodService->update($data,$id);

        return back()->with('success','Successfully neighborhood updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->neighborhoodService->delete($id);
        return back()->with('success','Successfully neighborhood deleted');

    }
}
