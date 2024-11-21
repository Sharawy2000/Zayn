<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    
    protected $cityService;
    public function __construct(CityService $cityService){
        $this->cityService = $cityService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = $this->cityService->all(5);
        return view('dashboard.cities.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.cities.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:80',
            'country_id'=>'required|integer|exists:countries,id',

        ]);

        $this->cityService->store($data);

        return back()->with('success','Successfully city created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $city = $this->cityService->get($id);
        return view('dashboard.cities.show',compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $city = $this->cityService->get($id);
        return view('dashboard.cities.edit',compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string|max:80',
            'country_id'=>'nullable|integer|exists:countries,id',
        ]);

        $this->cityService->update($data,$id);

        return back()->with('success','Successfully city updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cityService->delete($id);
        return back()->with('success','Successfully city deleted');

    }
}
