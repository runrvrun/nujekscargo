<?php
// Auth::routes();
Auth::routes(['register' => false]);
Route::post('userlogin','Auth\\LoginController@authenticate')->name('userlogin');
// Route::get('/hashunhashed','UserController@hashunhashed');
Route::group( ['middleware' => 'auth' ], function()
{
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/vehicle/indexjson','VehicleController@indexjson');
    Route::get('/vehicle/csvall','VehicleController@csvall');
    Route::get('/vehicle/destroymulti','VehicleController@destroymulti');
    Route::resource('/vehicle', 'VehicleController');
    Route::get('/branch/indexjson','BranchController@indexjson');
    Route::get('/branch/csvall','BranchController@csvall');
    Route::get('/branch/destroymulti','BranchController@destroymulti');
    Route::resource('/branch', 'BranchController');
    Route::get('/customer/indexjson','CustomerController@indexjson');
    Route::get('/customer/csvall','CustomerController@csvall');
    Route::get('/customer/destroymulti','CustomerController@destroymulti');
    Route::resource('/customer', 'CustomerController');
    Route::get('/user/indexjson','UserController@indexjson');
    Route::get('/user/csvall','UserController@csvall');
    Route::get('/user/destroymulti','UserController@destroymulti');
    Route::resource('/user', 'UserController');
    Route::get('/role', 'RoleController@privilege');
    Route::get('/role/{a}', 'RoleController@privilege');
    Route::patch('/role/privilegesave', 'RoleController@privilegesave');
    Route::get('/role/privilegejson/{a}', 'RoleController@privilegejson');

    Route::get('/spb/indexjson','SpbController@indexjson');
    Route::get('/spb/csvall','SpbController@csvall');
    Route::get('/spb/destroymulti','SpbController@destroymulti');
    Route::resource('/spb', 'SpbController');
    Route::get('/manifest/indexjson','ManifestController@indexjson');
    Route::get('/manifest/csvall','ManifestController@csvall');
    Route::get('/manifest/destroymulti','ManifestController@destroymulti');
    Route::resource('/manifest', 'ManifestController');
});