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
        Route::group(['middleware' => ['api', 'manage_token:api_admin,1|4']], function () {
            
            Route::post('getRekapAnggota', 'Api\Admin\ManagementController@getRekapAnggota');            

            Route::post('getDetailVerifikasiImportir', 'Api\Admin\ManagementController@detailVerifikasiImportir');      
            Route::post('submitVerifikasiImportir', 'Api\Admin\ManagementController@submitVerifikasiImportir');
            
            Route::post('getDetailVerifikasiEksportir', 'Api\Admin\ManagementController@detailVerifikasiEksportir');      
            Route::post('submitVerifikasiEksportir', 'Api\Admin\ManagementController@submitVerifikasiEksportir');

        }); 

        Route::group(['middleware' => ['api', 'manage_token:api_user,2|3']], function(){
                Route::post('getProdukList', 'Api\User\ProductController@findProductById');                
                Route::post('browseProduk', 'Api\User\ProductController@browseProduct');

                Route::post('insertProduk', 'Api\User\ProductController@insertProduct');
                Route::post('updateProduk', 'Api\User\ProductController@updateProduct');                
                Route::post('deleteProduk', 'Api\User\ProductController@deleteProduct');
                Route::post('detailProdukById', 'Api\User\ProductController@detailProduct');
        });
Route::namespace('Api')->group(function () {
            /*Contact Us*/
            Route::post('contactUs', 'ManagementNoAuthController@contactUs');
            /*Contact Us*/
                            
            Route::get('browseProdukFe', 'ProductNonAuthController@browseProduct');
            Route::post('browseProdukFeByKategori', 'ProductNonAuthController@browseProductByKategori');            
            Route::get('getKategori', 'ProductNonAuthController@findKategori');
            Route::post('detailProdukFe', 'ProductNonAuthController@detailProduk');
});
// });
