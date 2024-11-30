<?php
namespace App\Repositories\Contract;

interface BaseRepositoryInterface
{
    public function getAll($paginateNum);
    public function store($data);
    public function find($id);
    public function update($data,$id);
    public function remove($id);
    public function attach($model,$relation,$id,$data=[]);
    public function detach($model,$relation);
    public function sync($model,$relation,$id);
    public function updateColumnValue($model,$column,$value);
    public function checkByColumn($column,$value);
    public function getRelationData($model,$relation);
    public function getRelationValue($model,$relation,$value);
    public function getRelationQueryValue($model,$relation,$column,$value);
    public function getPivotColumnValue($model,$relation,string $column,$value,$target);
    public function checkPivotColumn($model,string $relation, string $column,$value);
    public function modelRelationAction($model,$relation,string $action);
    public function getFilteredData($filter,$pgn,$relations=[],$filterableFields=['id','name']);



}