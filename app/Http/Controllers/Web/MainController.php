<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use App\Services\ContactMessageService;
use App\Services\CountryService;
use App\Services\NeighborhoodService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $countryService;
    protected $cityService;
    protected $neighborhoodService;
    protected $contactMessageService;
    protected $productService;

    public function __construct(CountryService $countryService,
        CityService $cityService,
        NeighborhoodService $neighborhoodService,
        ContactMessageService $contactMessageService,
        ProductService $productService){
        $this->countryService = $countryService;
        $this->cityService = $cityService;
        $this->neighborhoodService = $neighborhoodService;
        $this->contactMessageService = $contactMessageService;
        $this->productService = $productService;
    }

    public function getAbout(){
        return view('web.about');
    }
    public function getContact(){
        return view('web.contact');
    }
    public function addContactMsg(Request $request){
        $data = $request->validate([
            'name'=>'required|string|max:50',
            'email'=>'required|email',
            'description'=>'required|string',
        ],[
            'name.required'=>'Name must be filled',
            'email.required'=>'Email must be filled',
            'description.required'=>'Description must be filled'
        ]);

        $this->contactMessageService->store($data);
    
        return back()->with('success','Message Sent Successfully');
    }
    public function getCities($id){
        $country = $this->countryService->get($id);
        $cities = $country->cities;
        return response()->json([
            'status' => 200,
            'data' => $cities,
        ]);
    }
    public function getNeighborhoods($id){
        $city = $this->cityService->get($id);
        $neighborhoods = $city->neighborhoods;
        return response()->json([
            'status' => 200,
            'data' => $neighborhoods,
        ]);
    }

    public function allProducts(){
        $products = $this->productService->all(10);
        return view('web.products.index',compact('products'));
    }
    public function showProduct($id){
        $product = $this->productService->get($id);
        return view('web.products.show',compact('product'));
    }
}
