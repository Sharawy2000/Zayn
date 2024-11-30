<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    public function  __construct(AuthService $authService){
        $this->authService = $authService;
    }
    public function getLogin(){
        return view('web.customer.auth.login');
    }
    public function postLogin(Request $request){
        $data = $request->validate([
            'phone' =>'required|string|exists:customers,phone',
            'password' =>'required|string'
        ]);

        $customer = $this->authService->login($data,true);

        if(isset($customer['errorCustomer'])){
            return back()->withErrors('Invalid Information, please try again')->withInput();
        }

        return redirect()->route('Home');
    }
    public function getRegister(){
        return view('web.customer.auth.register');
    }
    public function postRegister(Request $request){
        $data = $request->validate([
            'name'=>'required|string|max:50',
            'phone' =>'required|string|unique:customers,phone',
            'email' =>'required|email|unique:customers,email',
            'password' =>'required|string|confirmed',
            'neighborhood_id' =>'required|integer'
        ]);

        $customer = $this->authService->store($data);

        if(!$customer){
            return back()->withErrors('Invalid Information, please try again');
        }

        return redirect()->back()->with('success','Succeefully Registered');
    }
    public function logout(){
        $this->authService->logout(true);
        return redirect()->route('getSignIn')->with('success','Succeefully Sign Out');
    }
}
