<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;
    public function __construct(SettingService $settingService){
        $this->settingService = $settingService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = $this->settingService->get(1);
        return view('dashboard.settings.index',compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'app_title'=>'nullable|string',
            'about_us'=>'nullable|string',
            'andriod_link'=>'nullable|string',
            'ios_link'=>'nullable|string',
        ]);
        $this->settingService->update($data,$id);

        return back()->with('success','Successfully Setting updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
