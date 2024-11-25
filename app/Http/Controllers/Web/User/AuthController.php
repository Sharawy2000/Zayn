<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userService;
    public function  __construct(UserService $userService){
        $this->userService = $userService;
    }
    public function getLogin(){
        return view('dashboard.user.auth.login');
    }
    public function postLogin(Request $request){
        $data = $request->validate([
            'email' =>'required|email',
            'password' =>'required|string'
        ]);

        $user = $this->userService->loginProcess($data);

        if(isset($user['errorInfo'])){
            return back()->withErrors('Invalid Information, please try again')->withInput();
        }

        return redirect()->route('dashboard');
    }
    public function getRegister(){
        return view('dashboard.user.auth.register');
    }
    public function postRegister(Request $request){
        $data = $request->validate([
            'name'=>'required|string|max:50',
            'email' =>'required|email|unique:users,email',
            'password' =>'required|string|confirmed'
        ]);

        $user = $this->userService->store($data);

        if(!$user){
            return back()->withErrors('Invalid Information, please try again');
        }

        return redirect()->back()->with('success','Succeefully Registered');
    }
    public function logout(){
        $this->userService->logoutProcess();
        return redirect()->route('login')->with('success','Succeefully Sign Out');
    }
}
