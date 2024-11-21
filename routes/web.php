<?php

use App\Http\Controllers\Dashboard\{
    CityController,
    CountryController,
    CustomerController,
    NeighborhoodController,
    UserController,
};
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

    });
    Route::group([
        'prefix'=>'user',
        'controller'=>MainController::class,
        'middleware'=>'auth'
    ],function (){
        Route::get('profile','profile')->name('profile');
        Route::put('update-profile','updateProfile')->name('update-profile');
        Route::post('logout','logout')->name('logout');

        Route::post('reset-password','resetPassword')->name('reset-password');
    });
    Route::group([
        'prefix'=>'dashboard',
        'middleware'=>'auth'
    ],function(){
        Route::view('/','dashboard.index')->name('dashboard');
        Route::resource('users',UserController::class);
        Route::resource('customers',CustomerController::class);
        Route::resource('countries',CountryController::class);
        Route::resource('cities',CityController::class);
        Route::resource('neighborhoods',NeighborhoodController::class);
    });
});