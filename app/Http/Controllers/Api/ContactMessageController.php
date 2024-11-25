<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ContactMessageService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    use Helper;
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
        return $this->responseJson('contactMessages',$contactMessages);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'description'=>'required|string',
        ]);

        $message = $this->contactMessageService->store($data);

        return $this->responseJson('successfully message created',$message,201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = $this->contactMessageService->get($id);
        return $this->responseJson('message',$message);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string',
            'email'=>'nullable|email',
            'description'=>'nullable|string',
        ]);

        $message = $this->contactMessageService->update($data,$id);

        return $this->responseJson('successfully message updated',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->contactMessageService->delete($id);
        return $this->responseJson('successfully message deleted');

    }
}
