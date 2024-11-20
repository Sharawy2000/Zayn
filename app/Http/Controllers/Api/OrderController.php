<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use Helper;

    protected $orderService;

    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->orderService->all(5);

        return $this->responseJson('orders',$orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'shipping_address'=>"nullable|string"
        ]);
        $order = $this->orderService->placeOrder($data);
        return $this->responseJson('Order created successfully',$order);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = $this->orderService->get($id);
        return $this->responseJson('Order',$order);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
