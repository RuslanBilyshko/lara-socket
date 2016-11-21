<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',['as' => 'home','middleware' => 'guest', function () {
    return view('welcome');
}]);

Route::model('uid','App\Models\User');
Route::model('order','App\Models\Order');

// Пользователи
Route::group(['prefix' => 'user'], function(){
    Route::get('/list',  ['as' => 'userList', 'uses' => 'UserController@index']);
    Route::get('/{uid}/edit',  ['as' => 'userEdit', 'uses' => 'UserController@edit']);
    Route::post('/{uid}/edit',  ['as' => 'userEdit', 'uses' => 'UserController@update']);
});




//Заказы
Route::group(['prefix' => 'order'], function(){
    Route::get('create',  ['as' => 'order.create', 'uses' => 'OrderController@create']);
    Route::post('create',  ['as' => 'order.create', 'uses' => 'OrderController@store']);
    Route::get('{order}/edit',  ['as' => 'order.edit', 'uses' => 'OrderController@edit']);
    Route::post('{order}/edit',  ['as' => 'order.edit', 'uses' => 'OrderController@update']);
    Route::post('change/status',  ['as' => 'order.changeStatus', 'uses' => 'OrderController@changeStatus']);
    Route::get('/list',  ['as' => 'order.list', 'uses' => 'OrderController@index']);
});

//Официант
Route::group(['prefix' => 'waiter'], function(){
	Route::get('list',  ['as' => 'waiter.list', 'uses' => 'WaiterController@index']);

});

//Повар
Route::group(['prefix' => 'cook'], function(){
	Route::get('list',  ['as' => 'cook.list', 'uses' => 'CookController@index']);

});


// Маршруты аутентификации...
Route::group(['prefix' => 'auth'],function(){
    Route::get('login',  ['as' => 'getLogin', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('login', ['as' => 'postLogin', 'uses' => 'Auth\AuthController@postLogin']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

// Маршруты регистрации...
    Route::get('register', ['as' => 'getRegister', 'uses' => 'Auth\AuthController@getRegister']);
    Route::post('register', ['as' => 'postRegister', 'uses' => 'Auth\AuthController@postRegister']);
});



