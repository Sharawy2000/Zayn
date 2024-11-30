<?php
namespace App\Repositories\Contract;

interface CartItemRepositoryInterface
{
    public function getCustomerCartItems($id,$pgn);
}