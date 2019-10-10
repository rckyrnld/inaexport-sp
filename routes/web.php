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
//////////////////////////////////// START FRONTEND ////////////////////////////////////////////////////////////
Route::get('/registrasi_pembeli','RegistrasiController@registrasi_pembeli');
Route::post('/simpan_rpembeli','RegistrasiController@simpan_rpembeli');







//////////////////////////////////// END FRONTEND ////////////////////////////////////////////////////////////
//////////////////////////////////// START BACKEND ////////////////////////////////////////////////////////////

Route::get('/','HomeController@index');

// Group
Route::resource('/group','UM\GroupController');
Route::post('/group_save','UM\GroupController@store');
Route::get('/group_edit/{id}','UM\GroupController@edit');
Route::post('/group_update/{id}','UM\GroupController@update');
Route::get('/group_delete/{id}','UM\GroupController@destroy');

//user
Route::resource('/users','UM\UsersController');
Route::post('/user_save','UM\UsersController@store');
Route::get('/user_edit/{id}','UM\UsersController@edit');
Route::get('/getem/{id}', 'UM\UsersController@getem');
Route::post('/user_update/{id}','UM\UsersController@update');
Route::get('/user_delete/{id}','UM\UsersController@destroy');

//menu
Route::resource('/menus','UM\MenuController');
Route::get('/menu_add','UM\MenuController@create');
Route::post('/menu_save','UM\MenuController@store');
Route::get('/menu_edit/{id}','UM\MenuController@edit');
Route::post('/menu_update/{id}','UM\MenuController@update');
Route::get('/menu_delete/{id}','UM\MenuController@destroy');

Route::get('/submenu_add/{id}','UM\MenuController@create_submenu');
Route::post('/submenu_save','UM\MenuController@store_submenu');
Route::get('/submenu_edit/{id}','UM\MenuController@edit_submenu');
Route::post('/submenu_update/{id}','UM\MenuController@update_submenu');

//permissions
Route::resource('/permissions','UM\PermissionsController');
Route::post('/permission_save','UM\PermissionsController@store');
Route::get('/permission_edit/{id}','UM\PermissionsController@edit');
Route::post('/permission_update/{id}','UM\PermissionsController@update');
Route::get('/permission_delete/{id}','UM\PermissionsController@destroy');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/gantipass', 'HomeController@gantipass');
Route::post('/updatepass','HomeController@updatepass');

Route::namespace('Master')->group(function () {
	//Master Country
	Route::get('master-country/', 'MasterCountryController@index')->name('master.country.index');
	Route::get('master-country/create/', 'MasterCountryController@create')->name('master.country.create');
	Route::get('master-country/check-kode/', 'MasterCountryController@check')->name('master.country.kode');
	Route::get('master-country/edit/{id}', 'MasterCountryController@edit')->name('master.country.edit');
	Route::get('master-country/view/{id}', 'MasterCountryController@view')->name('master.country.view');
	Route::post('master-country/store/{param}','MasterCountryController@store')->name('master.country.store');
	Route::get('master-country/destroy/{id}', 'MasterCountryController@destroy')->name('master.country.destroy');
	Route::get('master-country/export/', 'MasterCountryController@export')->name('master.country.export');
	//Master City
	Route::get('master-city/', 'MasterCityController@index')->name('master.city.index');
	Route::get('master-city/create/', 'MasterCityController@create')->name('master.city.create');
	Route::get('master-city/edit/{id}', 'MasterCityController@edit')->name('master.city.edit');
	Route::get('master-city/view/{id}', 'MasterCityController@view')->name('master.city.view');
	Route::post('master-city/store/{param}','MasterCityController@store')->name('master.city.store');
	Route::get('master-city/destroy/{id}', 'MasterCityController@destroy')->name('master.city.destroy');
	Route::get('master-city/export/', 'MasterCityController@export')->name('master.city.export');
	//Master Province
	Route::get('master-province/', 'MasterProvinceController@index')->name('master.province.index');
	Route::get('master-province/create/', 'MasterProvinceController@create')->name('master.province.create');
	Route::get('master-province/check-kode/', 'MasterProvinceController@check')->name('master.province.kode');
	Route::get('master-province/edit/{id}', 'MasterProvinceController@edit')->name('master.province.edit');
	Route::get('master-province/view/{id}', 'MasterProvinceController@view')->name('master.province.view');
	Route::post('master-province/store/{param}','MasterProvinceController@store')->name('master.province.store');
	Route::get('master-province/destroy/{id}', 'MasterProvinceController@destroy')->name('master.province.destroy');
	Route::get('master-province/export/', 'MasterProvinceController@export')->name('master.province.export');
	//Master Port
	Route::get('master-port/', 'MasterPortController@index')->name('master.port.index');
	Route::get('master-port/create/', 'MasterPortController@create')->name('master.port.create');
	Route::get('master-port/edit/{id}', 'MasterPortController@edit')->name('master.port.edit');
	Route::get('master-port/view/{id}', 'MasterPortController@view')->name('master.port.view');
	Route::post('master-port/store/{param}','MasterPortController@store')->name('master.port.store');
	Route::get('master-port/destroy/{id}', 'MasterPortController@destroy')->name('master.port.destroy');
	Route::get('master-port/export/', 'MasterPortController@export')->name('master.port.export');
});

/////////////////////////////////////////ILYAS START//////////////////////////////////////////////////////////////////////////////////
Route::get('/annual_sales','EksportirController@index')->name('annual_sales.index');
Route::get('/tambah_annual','EksportirController@tambahannual');
Route::post('/annual_save','EksportirController@storeannual');
Route::get('sales_getdata','EksportirController@datanya')->name('datatables.sales');
Route::get('/sales_edit/{id}','EksportirController@edit')->name('sales.detail');
Route::get('/sales_view/{id}','EksportirController@view')->name('sales.view');
Route::post('/sales_update','EksportirController@updateannual');


//////////////////////////////////////////ILYAS END////////////////////////////////////////////////////////////////////////////////