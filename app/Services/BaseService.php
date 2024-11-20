<?php
namespace App\Services;

use App\Repositories\Contract\BaseRepositoryInterface;

class BaseService
{
    protected $repository;

    public function __construct(BaseRepositoryInterface $repository){
        $this->repository = $repository;
    }
    public function all($pgn){

        return $this->repository->getAll($pgn);

    }

    public function store($data){

        return $this->repository->store($data);

    }

    public function get($id){

        return $this->repository->find($id);

    }
    public function update($data, $id){

        return $this->repository->update($data,$id);

    }

    public function delete($id){

        $this->repository->remove($id);

    }

    public function removeImage($id){

        $model = $this->get($id);
        unlink($model->image);
    }

}