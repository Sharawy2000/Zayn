<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReviewService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use Helper;
    protected $reviewService;
    public function __construct(ReviewService $reviewService){
        $this->reviewService = $reviewService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = $this->reviewService->all(5);
        return $this->responseJson('All reviews', $reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'=>'required|integer|exists:products,id',
            'comment'=>'nullable|string',
            'rate'=>'nullable|integer|in:1,5',

        ]);
        $review = $this->reviewService->reviewCreate($data);
        return $this->responseJson('Review has been created', $review,201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = $this->reviewService->get($id);
        return $this->responseJson('Review', $review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'comment'=>'nullable|string',
            'rate'=>'nullable|integer|in:1,5',
        ]);
        $review = $this->reviewService->update($data,$id);
        return $this->responseJson('Review has been updated', $review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->reviewService->delete($id);
        return $this->responseJson('Review has been deleted',null);

    }
}
