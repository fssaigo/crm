<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/** JWT
Route::group(['middleware' => ['api','cors'],'prefix' => 'api'], function () {
    Route::post('register', 'ApiController@register');     // 注册
    Route::post('login', 'ApiController@login');           // 登陆
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('get_user_details', 'APIController@get_user_details');  // 获取用户详情
    });
});
*/

//Auth::routes();

Route::get('/', 'HomeController@commonView');
Route::get('/login', 'LoginController@show');
Route::post('/api/users/logout', 'LoginController@logout');
Route::post('/api/users/login', 'LoginController@login');
Route::post('/api/distribution','DistributionController@store');
Route::get('/menu','MenuController@index');
Route::get('/home', 'HomeController@commonView');
Route::get('/home/commonJson', 'HomeController@commonJson');
Route::get('/api/home/jwt', 'HomeController@jwt');
Route::post('/api/customers/visit', 'CustomerController@visit');
Route::get('/api/customers/visits', 'CustomerController@visits');
Route::get('/api/customers/customersByUserId', 'CustomerController@customersByUserId');
Route::get('/api/customers/customersByGroupId', 'CustomerController@customersByGroupId');
Route::get('/api/customers/customersByMerchantId', 'CustomerController@customersByMerchantId');
Route::get('/api/ponds/assign', 'PondController@assign');
Route::get('/api/ponds', 'PondController@index');
Route::get('/api/users/names', 'UserController@names');
Route::get('/api/users/merchant/{merchant}/group/{group}', 'UserController@findUserByMerchantGroup');
Route::resource('api/customers', 'CustomerController');
Route::resource('api/groups', 'GroupController');
Route::resource('api/merchants', 'MerchantController');
Route::resource('api/users', 'UserController');
Route::resource('api/channels', 'ChannelController');
Route::resource('api/ponds', 'PondController');
