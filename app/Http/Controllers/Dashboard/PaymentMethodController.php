<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\PaymentMethodService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    protected $paymentMethodService;
    public function __construct(PaymentMethodService $paymentMethodService){
        $this->paymentMethodService = $paymentMethodService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->search){
            
            $paymentMethods = $this->paymentMethodService->modelFilter($request->search,5);
        }else{
            $paymentMethods = $this->paymentMethodService->all(5);

        }
        return view('dashboard.payment-methods.index',compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.payment-methods.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:50'
        ]);

        $this->paymentMethodService->store($data);

        return back()->with('success','Successfully payment method created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentMethod = $this->paymentMethodService->get($id);
        return view('dashboard.payment-methods.show',compact('paymentMethod'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paymentMethod = $this->paymentMethodService->get($id);
        return view('dashboard.payment-methods.edit',compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string|max:50'
        ]);

        $this->paymentMethodService->update($data,$id);

        return back()->with('success','Successfully payment method updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->paymentMethodService->delete($id);
        return back()->with('success','Successfully payment method deleted');

    }
}