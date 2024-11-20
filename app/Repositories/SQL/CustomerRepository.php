<?php
namespace App\Repositories\SQL;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contract\CustomerRepositoryInterface;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    protected $customer;
    public function __construct(Customer $customer){
        parent::__construct($customer);
        $this->customer = $customer;
    }
   
    public function checkByPhone($phone){
        return $this->customer->where('phone',$phone)->firstOrFail();
    }

    public function createToken($model){
        return $model->createToken('Personal Access Token',['*'],now()->addMonth())->plainTextToken;
    }

    public function deleteToken($model){
        $model->currentAccessToken()->delete();
    }

    public function resetPassword($model,$password){
        $model->password = bcrypt($password);
        $model->reset_code = null;
        $model->save();
    }

    public function toggle($model,$id){
        return $model->favorites()->toggle($id);
    }

    public function customerCartSum($model){
        return $model->cart()->pluck(column: 'price')->sum();
    }

}