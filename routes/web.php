<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   return view('welcome');
   //return redirect()->to('/admin');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// admin routes
Route::group(['middleware'=>'auth' , 'prefix' => 'admin'],function(){
    Route::get('/','HomeController@index');
    Route::resource('category', 'CategoryController');
    Route::resource('city', 'CityController');
    Route::resource('region', 'RegionController');
    Route::resource('offer', 'OfferController');
    Route::resource('order','OrderController');
    Route::resource('client','ClientController');
    Route::resource('payment','PaymentController');
    Route::resource('transaction','TransactionController');
    Route::resource('contact','ContactController');
    Route::resource('restaurant','RestaurantController');
    Route::get('restaurant/{id}/activate', 'RestaurantController@activate');
    Route::get('restaurant/{id}/de-activate', 'RestaurantController@de_activate');
    Route::resource('{restaurant}/item', 'ItemController');


    Route::get('print/{id}','OrderController@print_invoice');

    Route::resource('setting_v2','Setting_v2Controller');
    Route::get('setting','SettingController@index');
    Route::post('setting','SettingController@update');

    // user reset
    Route::get('user/change-password','UserController@change_password');
    Route::post('user/change-password','UserController@change_password_save');
    Route::resource('user','UserController');

});
