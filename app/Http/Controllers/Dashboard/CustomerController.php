<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;
    public function __construct(CustomerService $customerService){
        $this->customerService = $customerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = $this->customerService->all(5);
        return view('dashboard.customers.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.customers.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:50',
            'phone'=>'required|string|unique:customers,phone',
            'email'=>'required|email|unique:customers,email',
            'password'=>'required|string|confirmed',
            'neighbourhood_id'=>'required|integer|exists:neighbourhoods,id'
        ]);

        $this->customerService->store($data);

        return back()->with('success','Customer successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = $this->customerService->get($id);
        return view('dashboard.customers.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = $this->customerService->get($id);
        return view('dashboard.customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'nullable|string|max:50',
            'phone'=>'nullable|string|unique:customers,phone,'.$id,
            'email'=>'nullable|email|unique:customers,email,'.$id,
            'password'=>'nullable|string|confirmed',
            'neighborhood_id'=>'nullable|integer|exists:neighborhoods,id'
        ]);
        $this->customerService->update($data,$id);
        return back()->with('success','Customer successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->customerService->delete($id);
    }
}
