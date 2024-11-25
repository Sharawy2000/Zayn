<?php

use App\Http\Controllers\Dashboard\{
    CategoryController,
    CityController,
    ColorController,
    ContactMessageController,
    CountryController,
    CustomerController,
    NeighborhoodController,
    OrderController,
    PaymentMethodController,
    ProductController,
    RoleController,
    SizeController,
    UserController,
};
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Web\User\{
    AuthController,
    MainController,
};
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('dashboard.index');
// })->name('dashboard')->middleware('auth');

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
        Route::resource('settings',SettingController::class);
    });
});