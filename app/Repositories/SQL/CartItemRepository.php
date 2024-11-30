<?php
namespace App\Repositories\SQL;

use App\Models\CartItem;
use App\Repositories\Contract\CartItemRepositoryInterface;

class CartItemRepository extends BaseRepository implements CartItemRepositoryInterface
{
    protected $cartItem;

    public function __construct(CartItem $cartItem){
        parent::__construct($cartItem);
        $this->cartItem = $cartItem;
    }
    public function getCustomerCartItems($id,$pgn){
        return $this->cartItem->where('cart_id',$id)->latest()->paginate($pgn);
    }
    
}