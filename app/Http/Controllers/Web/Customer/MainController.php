<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use App\Services\ContactMessageService;
use App\Services\CustomerService;
use App\Services\OrderService;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $customerService;
    protected $reviewService;
    protected $orderService;
    public function __construct(CustomerService $customerService,
    ReviewService $reviewService,
    OrderService $orderService
    ){
        $this->customerService = $customerService;
        $this->reviewService = $reviewService;
        $this->orderService = $orderService;
    }
    public function profile(){
        $user = $this->customerService->getProfile();
        return view('web.customer.profile',compact('user'));
    }

    public function updateProfile(Request $request){
        $data = $request->validate([
            'name'=>'nullable|string|max:50',
            'email'=>'nullable|email|max:50|unique:users,email,'.auth()->user()->id,
            'current_password'=>'required|string',
        ]);
        $result=$this->customerService->updateProcess($data);
        if(isset($result['errorPassword'])){
            return back()->withErrors('Invalid Password');
        }
        return back()->with('success','Successfully updated');
    }

    public function resetPassword(Request $request){
        $data = $request->validate([
            'old_password'=>'required|string',
            'password'=>'required|string|confirmed'
        ]);

        $result = $this->customerService->updatePassword($data);

        if(isset($result['errorPassword'])){
            return back()->withErrors('Invalid Password');
        }
        return back()->with('success','Password Successfully updated');

    }

    public function addToCart(Request $request){
        $data=$request->validate([
            'product_id'=>'required|integer|exists:products,id',
            'color_id'=>'required|integer|exists:colors,id',
            'size_id'=>'required|integer|exists:sizes,id',
            'quantity'=>'required|integer|min:1|max:100',
        ]);
        // dd($data);
        
        $this->customerService->productToCart($data,true);
        return back()->with('success','Added to cart'); 

    }

    public function addReview(Request $request){
        $data = $request->validate([
            'product_id'=>'required|integer|exists:products,id',
            'comment'=>'nullable|string',
            'rate'=>'nullable|integer|in:1,2,3,4,5',
        ]);
        $this->reviewService->reviewCreate($data,true);

        return back();
    }
    
    public function addToFavorites(Request $request){
        $data=$request->validate([
            'product_id'=>'required|integer|exists:products,id'
        ]);
        // dd($data);
        $result = $this->customerService->toggle($data,true);
        // return back;
        return $result;
    }
    
    public function favorites(){
        $favs = $this->customerService->myFavourties(true);
        return view('web.customer.my-favs',compact('favs'));
    }
    public function cart(){
        $cartItems = $this->customerService->cart(true);
        if(isset($cartItems['errorCartNotFound'])){
            return back()->withErrors('Cart not found');
        }
        return view('web.customer.my-cart',compact('cartItems'));
    }
    public function updateCart(Request $request){
        $data=$request->validate([
            'items'=>'nullable|array',
            'items.*'=>'required|integer',
            'quantities'=>'nullable|array',
            'quantities.*'=>'required|integer|min:1|max:100'
        ]);
        $this->customerService->updateCart($data,true);

        session()->forget('coupon_rate');

        return back()->with('success','Cart updated successfully');

    }
    public function deleteCartItem($id){

        $result = $this->customerService->deleteCartItem($id,true);
        
        if(isset($result['errorCartItemNotFound'])){
            return back()->withErrors('No such item found');
        }
        session()->forget('coupon_rate');

        return back()->with('success','Cart Item has been removed');
    }
    public function applyCoupon(Request $request){
        $data=$request->validate([
            'offer_coupon'=>'required|string|exists:offers,name'
        ]);
        $result = $this->customerService->applyCoupon($data,true);
        if(isset($result['expiredOffer'])){
            return back()->withErrors('Coupon expired');
        }
        session()->put('coupon_rate',$result->discount);
        

        return back()->with('success','Coupon successfully applied');
    }

    public function makeOrder(Request $request)
    {
        $data=$request->validate([
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'shipping_address'=>"nullable|string"
        ]);

        $this->orderService->placeOrder($data,true);
        return redirect()->route('Home');
        // return back()->with('success','Order has been placed successfully');
    }
    
    
    
}
