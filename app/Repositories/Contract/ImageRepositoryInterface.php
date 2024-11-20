<?php
namespace App\Repositories\Contract;

interface ImageRepositoryInterface
{
    public function attachImages($model,$image);
}