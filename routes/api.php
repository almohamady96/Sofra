<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheckCommissions;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix'=>'v1','namespace'=>'Api'],function (){

    Route::get('categories','MainController@categories');
    Route::get('cities','MainController@cities');
    Route::get('regions','MainController@regions');
    Route::get('cities-not-paginated','MainController@citiesNotPaginated');
    Route::get('regions-not-paginated','MainController@regionsNotPaginated');
    Route::get('regions_ajax','MainController@ajax_region');
    Route::get('payments','MainController@payments');

    Route::get('restaurants','MainController@restaurants');
    Route::get('restaurant','MainController@restaurant');
    Route::get('items','MainController@items');
    Route::get('restaurant/reviews','MainController@reviews');
    Route::get('offers','MainController@offers');
    Route::get('offer','MainController@offer');
    Route::post('contact','MainController@contact');
    Route::get('settings','MainController@settings');


    Route::group(['prefix'=>'client','namespace'=>'Client'],function (){
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('reset-password', 'AuthController@reset_password');
        Route::post('new-password', 'AuthController@new_password');

        Route::group(['middleware'=>'auth:client'],function() {
            Route::post('update-profile', 'AuthController@update_profile');
            Route::post('register-token-client', 'AuthController@register_token');
            Route::post('remove-token-client', 'AuthController@remove_token');
            Route::post('new-order','MainController@new_order');
            Route::get('my-orders','MainController@my_orders');
            Route::get('show-order','MainController@show_order');
            Route::get('latest-order','MainController@latest_order');
            Route::post('confirm-order','MainController@confirm_order');
            Route::post('decline-order','MainController@decline_order');
            Route::post('restaurant/review','MainController@review');
            Route::get('notifications','MainController@notifications');


        });
    });


    Route::group(['prefix'=>'restaurant','namespace'=>'Restaurant'],function (){
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('reset-password', 'AuthController@reset_password');
       Route::post('new-password', 'AuthController@new_password');
        Route::post('ShowInformation','MainController@ShowInformation');


        Route::group(['middleware'=>'auth:restaurant'],function() {
            Route::post('update-profile', 'AuthController@update_profile')->middleware('CheckCommissions');
            Route::post('register-token-restaurant', 'AuthController@register_token');
            Route::post('remove-token-restaurant', 'AuthController@remove_token');
            Route::post('new-item','MainController@new_item')->middleware('CheckCommissions');
            Route::post('update-item','MainController@update_item')->middleware('CheckCommissions');
            Route::post('delete-item','MainController@delete_item')->middleware('CheckCommissions');
            Route::get('my-items','MainController@my_items')->middleware('CheckCommissions');
            Route::post('new-offer','MainController@new_offer')->middleware('CheckCommissions');
            Route::post('update-offer','MainController@update_offer')->middleware('CheckCommissions');
            Route::post('delete-offer','MainController@delete_offer')->middleware('CheckCommissions');
            Route::get('my-offers','MainController@my_offers')->middleware('CheckCommissions');
            Route::post('change-status','MainController@change_status')->middleware('CheckCommissions');
            Route::get('notifications','MainController@notifications');
            Route::get('commissions','MainController@commissions');
            Route::get('my-orders','MainController@my_orders')->middleware('CheckCommissions');
            Route::get('show-order','MainController@show_order')->middleware('CheckCommissions');
            Route::post('accept-order','MainController@accept_order')->middleware('CheckCommissions');
            Route::post('reject-order','MainController@reject_order')->middleware('CheckCommissions');
            Route::post('confirm-order','MainController@confirm_order')->middleware('CheckCommissions');

        });



    });



});