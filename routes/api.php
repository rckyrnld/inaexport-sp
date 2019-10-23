<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:userApis')->get('/userApi', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('auth:adminApis')->get('/adminApi', function (Request $request) {
//     return $request->user();
// });

// $api = app('Dingo\Api\Routing\Router');

// $api->version('v1', function ($api){
        /*API Auth*/
        Route::group(['middleware' => ['api']], function () {
            Route::post('admin-login', 'Api\Auth\Admin\LoginController@login');
            Route::post('user-login', 'Api\Auth\User\LoginController@login');
        }); 
        /*API Auth*/ 
        /*************************************************************************************************************/
        Route::group(['middleware' => ['api', 'manage_token:admin_api,1|4']], function () {
            Route::get('getRekapAnggota', 'Api\Admin\ManagementController@getRekapAnggota');
        }); 
     
        // Route::group(['middleware' => 'auth.jwt'], function () { 
        //   /*API Management*/
        //         Route::get('getRekapAnggota', 'App\Http\Api\Controllers\ManagementController@getRekapAnggota');
        //     /*Anggota Importir*/
        //         Route::get('getDetailVerifikasiImportir', 'App\Http\Api\Controllers\ManagementController@detailVerifikasiImportir');
        //         Route::post('submitVerifikasiImportir', 'App\Http\Api\Controllers\ManagementController@submitVerifikasiImportir');
        //     /*Anggota Importir*/

        //     /*Anggota Eksportir*/
        //         Route::get('getDetailVerifikasiEksportir', 'App\Http\Api\Controllers\ManagementController@detailVerifikasiEksportir');
        //         Route::post('submitVerifikasiEksportir', 'App\Http\Api\Controllers\ManagementController@submitVerifikasiEksportir');
        //     /*Anggota Eksportir*/  
            
        //     /*Management Product*/
        //         Route::get('getProdukList', 'App\Http\Api\Controllers\ProductController@findProductById');                
        //         Route::get('browseProduk', 'App\Http\Api\Controllers\ProductController@browseProduct');

        //         Route::post('insertProduk', 'App\Http\Api\Controllers\ProductController@insertProduct');
        //         Route::post('updateProduk', 'App\Http\Api\Controllers\ProductController@updateProduct');                
        //         Route::post('deleteProduk', 'App\Http\Api\Controllers\ProductController@deleteProduct');
        //     /*Management Product*/

        // });
            /*Contact Us*/
            Route::post('contactUs', 'App\Http\Api\Controllers\ManagementNoAuthController@contactUs');
            /*Contact Us*/
                 
        /*API Management*/
// });
