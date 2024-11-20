<?php
namespace App\Repositories\SQL;

use App\Models\Cart;
use App\Repositories\Contract\CartRepositoryInterface;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    protected $cart;

    public function __construct(Cart $cart){
        parent::__construct($cart);
        $this->cart = $cart;
    }
    public function saveCartPrice($cart,$op,$price){
        if ($op === '+') {
            $cart->price += $price;  
        } elseif ($op === '-') {
            $cart->price -= $price;  
        }
        $cart->save();
    }
    
}