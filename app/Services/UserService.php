<?php 
namespace App\Services;

use App\Repositories\Contract\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository){
        parent::__construct($userRepository);
        $this->userRepository=$userRepository;
    }

    public function loginProcess($data){
        $user = $this->userRepository->checkByColumn('email',$data['email']);
        if(!$user||!Hash::check($data['password'],$user->password)){
            return ['errorInfo'=>true];
        }
        
        Auth::login($user,true);

        return $user;
    }
    
    public function getProfile(){
        $user = Auth::user();
        return $user;
    }

    public function updateProcess($data){
        $user = $this->getProfile();
        if(!Hash::check($data['current_password'],$user->password)){
            return ['errorPassword'=>true];
        }
        $this->update($data,$user->id);
    }
    public function logoutProcess(){
        Auth::logout();
    }

    public function updatePassword($data){
        $user = $this->getProfile();
        if(!Hash::check($data['old_password'],$user->password)){
            return ['errorPassword'=>true];
        }
        $data=[
            'password'=>bcrypt($data['password'])
        ];

        $this->update($data,$user->id);

    }
}