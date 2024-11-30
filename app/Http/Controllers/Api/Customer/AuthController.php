<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use Helper;
    protected $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }
    public function register(RegisterRequest $request){

        $data = $request->validated();

        $customer=$this->authService->store($data);

        return $this->responseJson('success registered',$customer,201);

    }
    public function login(LoginRequest $request){

        $data = $request->validated();

        $result=$this->authService->login($data);
        if(isset($result['errorCustomer'])){
            return $this->responseJson('There is an error, please try again',null,422);
        }
        return $this->responseJson('logged in success',[
            'token'=>$result['token'],
            'token_type'=>'Bearer',
            'customer'=>$result['customer']
        ]);

    }
    public function profile(){
        $customer = $this->authService->profile();
        return $this->responseJson('profile success',$customer);
    }

    public function updateProfile(Request $request){

        $customer = $this->authService->profile();

        $data = $request->validate([
            'name'=>'nullable|string|min:5|max:50',
            'email'=>'nullable|email|unique:customers,email,'.$customer->id,
            'phone'=>'nullable|string|unique:customers,phone,'.$customer->id,
            'neighborhood_id'=>'nullable|integer|exists:neighborhoods,id',
        ]);

        $updatedCustomer=$this->authService->update($data,$customer->id);

        return $this->responseJson('updated successfully',$updatedCustomer);
    }

    public function logout(){
        
        $this->authService->logout();
        
        return $this->responseJson('logged out successfully',null);
    }
}
