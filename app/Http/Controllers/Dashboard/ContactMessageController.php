<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ContactMessageService;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    protected $contactMessageService;
    public function __construct(ContactMessageService $contactMessageService){
        $this->contactMessageService = $contactMessageService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactMessages = $this->contactMessageService->all(5);
        return view('dashboard.contact-Messages.index',compact('contactMessages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->contactMessageService->delete($id);
        return back()->with('success','Successfully Message deleted');

    }
}
