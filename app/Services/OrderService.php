<?php 
namespace App\Services;

use App\Enums\OrderStatus;
use App\Repositories\Contract\CustomerRepositoryInterface;
use App\Repositories\Contract\NotificationRepositoryInterface;
use App\Repositories\Contract\OfferRepositoryInterface;
use App\Repositories\Contract\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class OrderService extends BaseService
{
    protected $orderRepository;
    protected $customerRepository;
    protected $offerRepository;
    protected $notificationRepository;

    public function __construct(OrderRepositoryInterface $orderRepository,
    CustomerRepositoryInterface $customerRepository,
    OfferRepositoryInterface $offerRepository,
    NotificationRepositoryInterface $notificationRepository){
        parent::__construct($orderRepository);
        $this->orderRepository=$orderRepository;
        $this->customerRepository=$customerRepository;
        $this->offerRepository=$offerRepository;
        $this->notificationRepository=$notificationRepository;
    }

    public function placeOrder($data,$isWeb=null){
        if($isWeb){
            $customer = Auth::guard('web-customer')->user();

        }else{

            $customer = Auth::guard('api-customer')->user();
        }
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
            $this->orderRepository->attach($order,'products',$item->product->id,[
                'quantity' => $item->quantity == 0 ? 1 : $item->quantity,
                'price_at_order'=>$price,
                'color_id'=>$item->color_id,
                'size_id'=>$item->size_id
            ]);
        }

        $this->customerRepository->modelRelationAction($customer,'cart','delete');

        return $order;
    }
    public function updateOrder($data,$id){
        $order = $this->update($data, $id);
        
        $notificationData=[
            'customer_id'=>$order->customer_id,
            'title'=>"Order #$order->id ". $order->status->name,
            'description'=>"Your Order has been ". $order->status->name,
        ];

        $this->notificationRepository->store($notificationData);


    }
    
}