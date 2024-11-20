<?php 
namespace App\Services;

use App\Repositories\Contract\CartItemRepositoryInterface;
use App\Repositories\Contract\CartRepositoryInterface;
use App\Repositories\Contract\CustomerRepositoryInterface;
use App\Repositories\Contract\OfferRepositoryInterface;
use App\Repositories\Contract\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerService extends BaseService
{
    protected $cartRepository;
    protected $cartItemRepository;
    protected $productRepository;
    protected $customerRepository;
    protected $offerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository,
    CartRepositoryInterface $cartRepository,
    ProductRepositoryInterface $productRepository,
    OfferRepositoryInterface $offerRepository,
    CartItemRepositoryInterface $cartItemRepository){
        parent::__construct($customerRepository);
        $this->customerRepository=$customerRepository;
        $this->cartRepository=$cartRepository;
        $this->productRepository=$productRepository;
        $this->offerRepository=$offerRepository;
        $this->cartItemRepository=$cartItemRepository;
    }

    public function customer(){
        $customer = Auth::guard('api-customer')->user();
        return $customer;
    }

    public function cart(){
        $customer =$this->customer();
        $cart = $customer->cart;
        if(!$cart){
            return ['errorCartNotFound'=>true];
        }
        $cartItems = $this->cartRepository->getRelationData($cart,'items');
        return $cartItems;
    }
    public function productToCart($data){
        $customer = $this->customer();
        $product=$this->productRepository->find($data['product_id']);    
        $data['customer_id']=$customer->id;
        
        $colorPriceAdjustment=$this->cartRepository->getPivotColumnValue($product,'colors','id',$data['color_id'],'price_adjustment');
        $sizePriceAdjustment=$this->cartRepository->getPivotColumnValue($product,'sizes','id',$data['size_id'],'price_adjustment');

        $totalPriceAdjustment=( $colorPriceAdjustment + $sizePriceAdjustment )*$data['quantity'];
        $data['price']=$product->price * $data['quantity'] + $totalPriceAdjustment;

        if($customer->cart == null){
            $cart=$this->cartRepository->store($data);
        }else{
            $cart = $customer->cart;
            $updatedPrice = $cart->price + $data['price'];
            $this->cartRepository->updateColumnValue($cart,'price',$updatedPrice);
        }

        $data['cart_id']=$cart->id;
        $data['price_adjustment']=$totalPriceAdjustment;

        $this->cartItemRepository->store($data);

        $this->cartRepository->updateColumnValue($cart,'price_after_offer',null);
            
        // $this->customerRepository->detach($customer,'offers');

        return $cart->load('items');
    }

    public function updateCart($data){
        $customer = $this->customer();
        $cart = $customer->cart;

        foreach($data['items'] as $index => $itemID){

            $quantity = $data['quantities'][$index];
            $cartItem = $this->cartItemRepository->find($itemID);
            $product = $this->productRepository->find($cartItem->product_id);

            $oldProductPrice = $product->price * $cartItem->quantity + $cartItem->price_adjustment;
            $this->cartRepository->saveCartPrice($cart,'-',$oldProductPrice); 

            $colorPriceAdjustment=$this->cartRepository->getPivotColumnValue($product,'colors','id',$cartItem->color_id,'price_adjustment');
            $sizePriceAdjustment=$this->cartRepository->getPivotColumnValue($product,'sizes','id',$cartItem->size_id,'price_adjustment');

            $totalPriceAdjustment=( $colorPriceAdjustment + $sizePriceAdjustment )*$quantity;

            $this->cartItemRepository->updateColumnValue($cartItem,'quantity',$quantity);
            $this->cartItemRepository->updateColumnValue($cartItem,'price_adjustment',$totalPriceAdjustment);

            $newProductPrice = $quantity * $product->price + $totalPriceAdjustment;
            $this->cartRepository->saveCartPrice($cart,'+',$newProductPrice); 

            
        }
        $this->cartRepository->updateColumnValue($cart,'price_after_offer',null);
        
        // $this->customerRepository->detach($customer,'offers');
    }
    public function deleteCartItem($id){
        $customer = $this->customer();
        $cart = $customer->cart;
        $cartItem=$this->cartItemRepository->getRelationQueryValue($cart,'items','id',$id);
        if(!$cartItem){
            return ['errorCartItemNotFound'=>true];
        }
        $itemPrice = $cartItem->product->price * $cartItem->quantity + $cartItem->price_adjustment;

        $this->cartRepository->saveCartPrice($cart,'-',$itemPrice);

        $this->cartItemRepository->remove($id);

        // $this->customerRepository->detach($customer,'offers');

        $this->cartRepository->updateColumnValue($cart,'price_after_offer',null);
    }

    public function applyCoupon($data){
        $customer = $this->customer();
        $offer = $this->offerRepository->checkByColumn('name', $data['offer_coupon']);

        // $isOfferUsed = $this->offerRepository->checkPivotColumn($customer,'offers','offer_id',$offer->id);

        // if($isOfferUsed){
        //     return ['errorCouponUsedOnce'=>true];
        // }else{
        //     if($offer->date_begin <= now() && $offer->date_end > now()){
        //         $cart = $customer ->cart;
        //         $dicountedPrice = $cart->price * $offer->discount / 100;

        //         $priceAfterOffer = $cart->price - $dicountedPrice;

        //         $this->cartRepository->updateColumnValue($cart,'price_after_offer',$priceAfterOffer);

        //         $this->cartItemRepository->attach($customer,'offers',$offer->id);
                
        //     }else{
        //         return['expiredOffer'=>true];
        //     }
        // }
        if($offer->date_begin <= now() && $offer->date_end > now()){
            $cart = $customer ->cart;
            $dicountedPrice = $cart->price * $offer->discount / 100;

            $priceAfterOffer = $cart->price - $dicountedPrice;

            $this->cartRepository->updateColumnValue($cart,'price_after_offer',$priceAfterOffer);

            // $this->cartItemRepository->attach($customer,'offers',$offer->id);
            
        }else{
            return['expiredOffer'=>true];
        }
    }
    public function myFavourties(){
        $customer = $this->customer();
        $favourties = $this->customerRepository->getRelationData($customer, 'favorites');
        return $favourties;
    }
    public function toggle($data){
        $customer = $this->customer();
        $favToggle=$this->customerRepository->toggle($customer, $data['product_id']);
        return $favToggle;
    }
}