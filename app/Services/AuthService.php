<?php 
namespace App\Services;

use App\Repositories\Contract\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository){
        parent::__construct($customerRepository);
        $this->customerRepository=$customerRepository;
    }
    public function login($data,$isWeb=null){
        // check if user phone is already registered
        $customer = $this->customerRepository->checkByPhone($data['phone']);

        if (!$customer || !Hash::check($data['password'],$customer->password)){
            
                return ['errorCustomer'=>true];
            
        }
        if(!$isWeb){
            $token = $this->customerRepository->createToken($customer);
            return ['token'=>$token,'customer'=>$customer];
        }else{
            Auth::guard('web-customer')->login($customer);
        }

    }

    public function profile($isWeb=null){
        if($isWeb){
            $customer = Auth::guard('web-customer')->user();

        }else{

            $customer = Auth::guard('api-customer')->user();
        }
        return $customer;
    }
    public function logout($isWeb=null){
        if($isWeb){
            $customer = $this->profile(true);
            Auth::guard('web-customer')->logout();
        }else{
            $customer = $this->profile();
            $this->customerRepository->deleteToken($customer);
        }
    }

}