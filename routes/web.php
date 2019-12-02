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
    Route::get('/spb/searchjson','SpbController@searchjson');
    Route::get('/spb/{a}/track','SpbController@track');
    Route::get('/spb/{a}/report','SpbController@report');
    Route::resource('/spb', 'SpbController');
    Route::get('/manifest/{a}/spb/indexjson','ManifestController@spbindexjson');
    Route::get('/manifest/{a}/spb/csvall','ManifestController@spbcsvall');
    Route::post('/manifest/spb/destroy','ManifestController@spbdestroy');
    Route::get('/manifest/spb/destroymulti','ManifestController@spbdestroymulti');
    Route::post('/manifest/spb/setmanifestmulti','ManifestController@setmanifestmulti');    
    Route::post('/manifest/spb/updatestatus','ManifestController@spbupdatestatus');    
    Route::get('/manifest/{a}/spb','ManifestController@spbindex');
    Route::get('/manifest/{a}/report','ManifestController@report');
    Route::get('/manifest/indexjson','ManifestController@indexjson');
    Route::get('/manifest/csvall','ManifestController@csvall');
    Route::get('/manifest/destroymulti','ManifestController@destroymulti');
    Route::resource('/manifest', 'ManifestController');
    Route::get('/spb/{a}/item/indexjson','ItemController@indexjson');
    Route::get('/spb/{a}/item/csvall','ItemController@csvall');
    Route::get('/spb/{a}/item/destroymulti','ItemController@destroymulti');
    Route::resource('/spb/{a}/item', 'ItemController');
    Route::resource('/item', 'ItemController');

});