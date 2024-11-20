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
    public function register($data){
        
        $customer = $this->store($data);

        return $customer;
        

    }
    public function login($data){
        // check if user phone is already registered
        $customer = $this->customerRepository->checkByPhone($data['phone']);

        if (!$customer || !Hash::check($data['password'],$customer->password)){
            return ['errorCustomer'=>true];
        }

        $token = $this->customerRepository->createToken($customer);

        return ['token'=>$token,'customer'=>$customer];
    }

    public function profile(){
        $customer = Auth::guard('api-customer')->user();
        return $customer;
    }
    public function logout(){
        $customer = $this->profile();
        $this->customerRepository->deleteToken($customer);
    }

}