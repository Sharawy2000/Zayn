<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryService;
    public function __construct(CountryService $countryService){
        $this->countryService = $countryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->search){
            
            $countries = $this->countryService->modelFilter($request->search,5);
        }else{
            $countries = $this->countryService->all(5);

        }
        return view('dashboard.countries.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.countries.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:80'
        ]);

        $this->countryService->store($data);

        return back()->with('success','Successfully country created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $country = $this->countryService->get($id);
        return view('dashboard.countries.show',compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $country = $this->countryService->get($id);
        return view('dashboard.countries.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string|max:80'
        ]);

        $this->countryService->update($data,$id);

        return back()->with('success','Successfully country updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->countryService->delete($id);
        return back()->with('success','Successfully country deleted');

    }
}
