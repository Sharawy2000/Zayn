<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Customer\AuthController;
use App\Http\Controllers\Api\Customer\MainController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ResetPasswordController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix'=>'v1'
], function(){

    Route::group([
        'prefix'=>'auth',
        'controller'=>AuthController::class
    ], function(){
        Route::post('/login','login');
        Route::post('/register','register');
    });
    
    Route::group([
        'prefix'=>'customer',
        'middleware'=>'auth:sanctum'
    ], function(){
        Route::controller(AuthController::class)->group(function (){        
            Route::get('/profile','profile');
            Route::patch('/update-profile','updateProfile');
            Route::post('/logout','logout');
        });
        Route::controller(MainController::class)->group(function (){
            // service of customers
            Route::get('/cart','getCart');
            Route::post('/add-to-cart','addToCart');
            Route::patch('/update-cart','updateCart');
            Route::delete('/remove-from-cart/{itemID}','deleteCartItem');
            // coupon
            Route::post('/apply-coupon','addCoupon');
            // favourates 
            Route::get('/favorites','getFavorites');
            Route::post('/add-to-favorites','addToFavorites');
                
        });
    });

    Route::group([
        'prefix'=>'password',
        'controller'=>ResetPasswordController::class
    ], function(){
        Route::post('/forgot','forgotPassword');
        Route::post('/reset','resetPassword');
    });

    Route::apiResource('categories',CategoryController::class)->middleware('auth:sanctum');
    Route::apiResource('offers',OfferController::class)->middleware('auth:sanctum');
    Route::apiResource('products',ProductController::class)->middleware('auth:sanctum');
    Route::apiResource('orders',OrderController::class)->middleware('auth:sanctum');
});
