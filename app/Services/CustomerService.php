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

    public function customer($isWeb=null){
        if($isWeb){

            $customer = Auth::guard('web-customer')->user();
        }else{

            $customer = Auth::guard('api-customer')->user();
        }
        return $customer;
    }

    public function cart($isWeb=null){
        $customer =$this->customer($isWeb);
        $cart = $customer->cart;
        if(!$cart){
            return ['errorCartNotFound'=>true];
        }
        // $cartItems = $this->cartRepository->getRelationData($cart,'items');
        $cartItems = $this->cartItemRepository->getCustomerCartItems($cart->id,3);
        return $cartItems;
    }
    public function productToCart($data,$isWeb=null){
        $customer = $this->customer($isWeb);
        // dd($customer);
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
            
        return $cart->load('items');
    }

    public function updateCart($data,$isWeb=null){
        $customer = $this->customer($isWeb);
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
        
    }
    public function deleteCartItem($id,$isWeb=null){
        $customer = $this->customer($isWeb);
        $cart = $customer->cart;
        $cartItem=$this->cartItemRepository->getRelationQueryValue($cart,'items','id',$id);
        if(!$cartItem){
            return ['errorCartItemNotFound'=>true];
        }
        $itemPrice = $cartItem->product->price * $cartItem->quantity + $cartItem->price_adjustment;

        $this->cartRepository->saveCartPrice($cart,'-',$itemPrice);

        $this->cartItemRepository->remove($id);

        $this->cartRepository->updateColumnValue($cart,'price_after_offer',null);
    }

    public function applyCoupon($data,$isWeb=null){
        $customer = $this->customer($isWeb);
        $offer = $this->offerRepository->checkByColumn('name', $data['offer_coupon']);

        if($offer->date_begin <= now() && $offer->date_end > now()){
            $cart = $customer ->cart;
            $dicountedPrice = $cart->price * $offer->discount / 100;

            $priceAfterOffer = $cart->price - $dicountedPrice;

            $this->cartRepository->updateColumnValue($cart,'price_after_offer',$priceAfterOffer);

            return $offer;

        }else{
            return['expiredOffer'=>true];
        }
    }
    public function myFavourties($isWeb=null){
        $customer = $this->customer($isWeb);
        $favourties = $this->customerRepository->getRelationData($customer, 'favorites');
        return $favourties;
    }
    public function toggle($data,$isWeb=null){
        $customer = $this->customer($isWeb);
        $favToggle=$this->customerRepository->toggle($customer, $data['product_id']);
        return $favToggle;
    }
}