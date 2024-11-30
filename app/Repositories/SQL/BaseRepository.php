<?php
namespace App\Repositories\SQL;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contract\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    protected $defaultFilterableFields = ['name', 'id'];

    public function __construct(Model $model){
        $this->model = $model;
    }
    public function getAll($paginateNum){
        return $this->model->latest()->paginate($paginateNum);
    }
    public function store($data){
        return $this->model->create($data);
    }
    public function find($id){
        return $this->model->findOrFail($id);
    }
    public function update($data,$id){
        $model=$this->find($id);
        $model->update($data);
        return $model;
    }
    public function remove($id){
        $module=$this->find($id);
        $module->delete();
    }
    public function attach($model,$relation,$id,$data=[]){
        $model->$relation()->attach($id,$data);
    }
    public function detach($model,$relation){
        $model->$relation()->detach();
    }
    public function sync($model,$relation,$id){
        $model->$relation()->sync($id);
    }

    public function updateColumnValue($model,$column,$value){
        $model->$column = $value;
        $model->save();
    }
    public function checkByColumn($column,$value){
        return $this->model->where($column,$value)->first();
    }

    public function getRelationData($model,$relation){
        return $model->$relation()->get();
    }
    public function getRelationValue($model,$relation,$value){
        return $model->$relation->$value;
    }
    public function getRelationQueryValue($model,$relation,$column,$value){
        return $model->$relation()->where($column,$value)->first();

    }
    public function getPivotColumnValue($model,$relation,string $column,$value,$target){
        return $model->$relation->where($column,$value)->first()?->pivot->$target?? 0;
    }
    public function checkPivotColumn($model,string $relation, string $column,$value){
        return $model->$relation()->wherePivot($column,$value)->exists();
    }
    public function modelRelationAction($model,$relation,string $action){
        return $model->$relation()->$action();
    }
    public function getFilteredData($filter,$pgn,$relations=[],$filterableFields=null){

        $filterableFields ??= $this->defaultFilterableFields;
        
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            foreach ($relations as $relation) {
                $query->orWhereHas($relation, function ($query) use ($filter) {
                    $query->where('name', 'like', '%' . $filter . '%');
                });
            }
        }
        $query->orWhere(function($query) use($filter,$filterableFields){
            foreach($filterableFields as $field){
                $query->orWhere($field, 'like', '%' . $filter . '%');
            }
        });

        
        return $query->latest()->paginate($pgn);
    }
    



}