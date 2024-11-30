<?php

use App\Http\Controllers\Dashboard\{
    CategoryController,
    CityController,
    ColorController,
    ContactMessageController,
    CountryController,
    CustomerController,
    HomeSlideController,
    NeighborhoodController,
    OrderController,
    PaymentMethodController,
    ProductController,
    RoleController,
    SizeController,
    UserController,
};
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Web\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Web\Customer\MainController as CustomerMainController;
use App\Http\Controllers\Web\MainController as WebMainController;
use App\Http\Controllers\Web\User\{
    AuthController,
    MainController,
};
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'=>'v1'
],function (){

    Route::group([
        'prefix'=>'auth',
        'controller'=>AuthController::class
    ],function (){

        Route::get('login','getLogin')->name('login');
        Route::post('login','postLogin')->name('post-login');

        Route::get('register','getRegister')->name('get-register');
        Route::post('register','postRegister')->name('post-register');

        Route::post('logout','logout')->name('logout')->middleware('auth');
    });
    Route::group([
        'prefix'=>'user',
        'controller'=>MainController::class,
        'middleware'=>'auth'
    ],function (){
        Route::get('profile','profile')->name('profile');
        Route::put('update-profile','updateProfile')->name('update-profile');

        Route::post('reset-password','resetPassword')->name('reset-password');
    });
    Route::group([
        'prefix'=>'dashboard',
        'middleware'=>['auth','check-permission']
    ],function(){
        Route::view('/','dashboard.index')->name('dashboard');

        Route::resource('users',UserController::class);
        Route::resource('customers',CustomerController::class);
        Route::resource('countries',CountryController::class);
        Route::resource('cities',CityController::class);
        Route::resource('neighborhoods',NeighborhoodController::class);
        Route::resource('colors',ColorController::class);
        Route::resource('sizes',SizeController::class);
        Route::resource('categories',CategoryController::class);
        Route::resource('products',ProductController::class);
        Route::resource('payment-methods',PaymentMethodController::class);
        Route::resource('orders',OrderController::class);
        Route::resource('roles',RoleController::class);
        Route::resource('contact-messages',ContactMessageController::class);
        Route::resource('home-slides',HomeSlideController::class);
        Route::resource('settings',SettingController::class);
    });

    Route::view('/','web.index')->name('Home');

    Route::group([
        'prefix'=>'web/auth',
        'controller'=>CustomerAuthController::class
    ],function(){
        Route::get('/sign-up','getRegister')->name('getSignUp');
        Route::get('/sign-in','getLogin')->name('getSignIn');
        Route::post('/sign-up','postRegister')->name('postSignUp');
        Route::post('/sign-in','postLogin')->name('postSignIn');
        Route::post('/logout','logout')->name('web-logout');

    });
    Route::group([
        'prefix'=>'customer',
        'controller'=>CustomerMainController::class,
        'middleware'=>'is-customer',
    ],function(){
        Route::post('add-to-cart','addToCart')->name('web-addToCart');
        Route::post('add-review','addReview')->name('add-review');
        Route::post('add-favs','addToFavorites')->name('add-favs');
        Route::get('favs','favorites')->name('favs');
        Route::get('cart','cart')->name('cart');
        Route::patch('update-cart','updateCart')->name('update-cart');
        Route::get('remove-item/{id}','deleteCartItem')->name('remove-item');
        Route::post('apply-coupon','applyCoupon')->name('apply-coupon');
    });
    
    Route::group([
        'controller'=>WebMainController::class
    ],function(){

        Route::post('add-contact-message','addContactMsg')->name('add-ContactMsg');
        Route::get('get-countries','getCountries');
        Route::get('get-cities/{id}','getCities');
        Route::get('get-neighborhoods/{id}','getNeighborhoods');


        Route::get('about','getAbout')->name('about');
        Route::get('contact','getContact')->name('contact');

        // products 
        Route::get('shop','allProducts')->name('shop');
        Route::get('all-products/{id}','showProduct')->name('show-product');

        
    });
    
});
