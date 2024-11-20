<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PasswordService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use Helper;
    protected $passwordService;

    public function __construct(PasswordService $passwordService){
        $this->passwordService = $passwordService;
    }
    public function forgotPassword(Request $request){
        $data=$request->validate([
            'phone'=>'required|string|exists:customers,phone'
        ]);

        $result = $this->passwordService->forgot($data['phone']);

        if(isset($result['errorCustomer'])){
            return $this->responseJson('Error in information',null,422);
        }

        return $this->responseJson('code is sent');

    }
    public function resetPassword(Request $request){

        $data=$request->validate([
            'code'=>'required|string',
            'password'=>'required|string|confirmed'
        ]);

        $result=$this->passwordService->reset($data);

        if(isset($result['errorCode'])){
            return $this->responseJson('code is invalid',null,422);
        }

        return $this->responseJson('password updated succesfully');

    }
}
