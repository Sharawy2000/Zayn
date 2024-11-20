<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OfferService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use Helper;
    protected $offerService;
    public function __construct(OfferService $offerService){
        $this->offerService = $offerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = $this->offerService->all(5);
        return $this->responseJson('offers',$offers);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'discount'=>'required|integer',
            'date_begin'=>'required|date',
            'date_end'=>'required|date',
        ]);

        $offer = $this->offerService->store($data);

        return $this->responseJson('successfully offer created',$offer,201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $offer = $this->offerService->get($id);
        return $this->responseJson('offer',$offer);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string',
            'description'=>'nullable|string',
            'discount'=>'nullable|integer',
            'date_begin'=>'nullable|date',
            'date_end'=>'nullable|date',
        ]);

        $offer = $this->offerService->update($data,$id);

        return $this->responseJson('successfully offer updated',$offer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->offerService->delete($id);
        return $this->responseJson('successfully offer deleted');

    }
}
