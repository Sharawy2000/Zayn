<?php
namespace App\Repositories\Contract;

interface CartRepositoryInterface
{
    public function saveCartPrice($cart,$op,$price);
}