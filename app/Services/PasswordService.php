<?php 
namespace App\Services;

use App\Mail\SendForgetPassword;
use App\Repositories\SQL\CustomerRepository;
use Illuminate\Support\Facades\Mail;

class PasswordService extends BaseService
{
    protected $customerRepository;
    public function __construct(CustomerRepository $customerRepository){
        $this->customerRepository = $customerRepository;
    }
    public function forgot($data){
        // 1 => get phone 
        // 2 => check phone
        // 3 => generate code and save it
        // 4 => send Mail message to customer email 
        $customer = $this->customerRepository->checkByPhone($data);
        
        if(!$customer){
            return ['errorCustomer'=>true];
        }

        $code = rand(111111,999999);

        $this->customerRepository->updateColumnValue($customer,'reset_code',$code);

        Mail::to($customer->email)->send(new SendForgetPassword($customer));


    }

    public function reset($data){
        // 1 => check code and new password 
        $customer = $this->customerRepository->checkByColumn('reset_code',$data['code']);
        if(!$customer){
            return ['errorCode'=>true];
        }

        // change password

        $this->customerRepository->resetPassword($customer,$data['password']);

    }
}