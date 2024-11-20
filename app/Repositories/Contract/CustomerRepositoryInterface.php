<?php
namespace App\Repositories\Contract;

interface CustomerRepositoryInterface
{
    public function checkByPhone($phone);
    public function createToken($model);
    public function deleteToken($model);
    public function resetPassword($model,$password);
    public function toggle($model,$id);
    public function customerCartSum($model);


}