<?php 
namespace App\Services;

use App\Repositories\Contract\RoleRepositoryInterface;

class RoleService extends BaseService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository){
        parent::__construct($roleRepository);
        $this->roleRepository=$roleRepository;
    }

    public function makeRole($data){
        $role = $this->store($data);
        $this->roleRepository->attach($role,'permissions',$data['permissions']);
    }
    public function updateRole($data,$id){
        $role = $this->update($data,$id);
        $this->roleRepository->sync($role,'permissions',$data['permissions']);
    }
    
    
    
}