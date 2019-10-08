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


/////////////////////////////////////////ILYAS START//////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////ILYAS END////////////////////////////////////////////////////////////////////////////////