<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class MainController extends Controller
{
    use Helper;
    protected $customerService;
    public function __construct(CustomerService $customerService){
        $this->customerService = $customerService;
    }
    public function getCart(){
        $cart = $this->customerService->cart();
        if(isset($cart['errorCartNotFound'])){
            return $this->responseJson('There is no items in cart',null);
        }
        return $this->responseJson('cart',$cart);

    }
    public function addToCart(Request $request){
        $data=$request->validate([
            'product_id'=>'required|integer|exists:products,id',
            'color_id'=>'required|integer|exists:colors,id',
            'size_id'=>'required|integer|exists:sizes,id',
            'quantity'=>'required|integer|min:1|max:100',
        ]);

        $cartProduct=$this->customerService->productToCart($data);

        return $this->responseJson('Successfully added to cart',$cartProduct);

    }
    public function updateCart(Request $request){
        $data=$request->validate([
            'items'=>'nullable|array',
            'items.*'=>'required|integer',
            // 'products'=>'nullable|array',
            // 'products.*'=>'required|integer|exists:products,id',
            'quantities'=>'nullable|array',
            'quantities.*'=>'required|integer|min:1|max:100'
        ]);

        $result = $this->customerService->updateCart($data);
        if(isset($result['errorItemNotFound'])){
            return $this->responseJson('There is no cart item',null,422);
        }

        return $this->responseJson('Cart Updated Successfully',$result);

    }
    public function deleteCartItem($itemID){
        $result = $this->customerService->deleteCartItem($itemID);
        if(isset($result['errorCartItemNotFound'])){
            return $this->responseJson('Cart Item Error',null,422);
        }
        return $this->responseJson('Cart Item Deleted Successfully',$result);
    }
    public function getFavorites(){
        $favs = $this->customerService->myFavourties();
        return $this->responseJson('My Favorites',$favs);
    }
    public function addToFavorites(Request $request){
        $data=$request->validate([
            'product_id'=>'required|integer|exists:products,id'
        ]);
        $toggle = $this->customerService->toggle($data);
        return $this->responseJson($toggle['attached']?'Added to favorites':'Removed from favorites',$toggle);
    }

    public function addCoupon(Request $request){
        $data=$request->validate([
            'offer_coupon'=>'required|string|exists:offers,name'
        ]);

        $result = $this->customerService->applyCoupon($data);
        if(isset($result['expiredOffer'])){
            return $this->responseJson('Expired offer',null,401);
        }
        if(isset($result['errorCouponUsedOnce'])){
            return $this->responseJson('Used only once',null,403);
        }

        return $this->responseJson('Coupon successfully applied',$result);
    }

}
