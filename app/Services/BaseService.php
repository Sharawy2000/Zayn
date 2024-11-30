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

    public function attach($model,$relation,$id){
        $this->repository->attach($model,$relation,$id);
    }
    public function sync($model,$relation,$id){
        $this->repository->sync($model,$relation,$id);
    }
    public function modelFilter($filter,$pgn,$relation=null,$filterableFields=null){
        return  $this->repository->getFilteredData($filter,$pgn,$relation,$filterableFields);
    }

}