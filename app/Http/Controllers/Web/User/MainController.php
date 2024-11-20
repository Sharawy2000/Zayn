<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    public function profile(){
        $user = $this->userService->getProfile();
        return view('dashboard.user.profile',compact('user'));
    }

    public function updateProfile(Request $request){
        $data = $request->validate([
            'name'=>'nullable|string|max:50',
            'email'=>'nullable|email|max:50|unique:users,email,'.auth()->user()->id,
            'current_password'=>'required|string',
        ]);
        $result=$this->userService->updateProcess($data);
        if(isset($result['errorPassword'])){
            return back()->withErrors('Invalid Password');
        }
        return back()->with('success','Successfully updated');
    }

    public function resetPassword(Request $request){
        $data = $request->validate([
            'old_password'=>'required|string',
            'password'=>'required|string|confirmed'
        ]);

        $result = $this->userService->updatePassword($data);

        if(isset($result['errorPassword'])){
            return back()->withErrors('Invalid Password');
        }
        return back()->with('success','Password Successfully updated');

    }
}
