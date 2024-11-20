<?php 
namespace App\Services;

use App\Enums\OrderStatus;
use App\Repositories\Contract\CustomerRepositoryInterface;
use App\Repositories\Contract\OfferRepositoryInterface;
use App\Repositories\Contract\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class OrderService extends BaseService
{
    protected $orderRepository;
    protected $customerRepository;
    protected $offerRepository;

    public function __construct(OrderRepositoryInterface $orderRepository,
    CustomerRepositoryInterface $customerRepository,
    OfferRepositoryInterface $offerRepository){
        parent::__construct($orderRepository);
        $this->orderRepository=$orderRepository;
        $this->customerRepository=$customerRepository;
        $this->offerRepository=$offerRepository;
    }

    public function placeOrder($data){

        $customer = Auth::guard('api-customer')->user();
        $data['customer_id']=$customer->id;
        $customerCart = $customer->cart;

        $shippingFees = $customerCart->price > 100 ? 0 : 100 ;

        $data['shipping_fees']=$shippingFees;
        $data['price_after_offer']=$customerCart->price_after_offer + $shippingFees;
        $data['total_price']=$customerCart->price + $shippingFees;
        

        $data['status']=OrderStatus::Pending;

        $order = $this->store($data);
        
        $cartItems = $this->customerRepository->getRelationData($customerCart,'items');

        foreach($cartItems as $item){
            // dd($item);
            $price = $item->product->price * $item->quantity + $item->price_adjustment;
            $this->orderRepository->attach($order,'products',$item->product->id,['quantity' => $item->quantity,'price_at_order'=>$price]);
        }

        $this->customerRepository->modelRelationAction($customer,'cart','delete');

        return $order;
    }
    
}