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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api){
        /*API Auth*/
            $api->post('login', 'App\Http\Controllers\Api\Auth\LoginController@login');
            $api->post('register', 'App\Http\Controllers\Api\Auth\RegisterController@register');
            $api->post('logout', 'App\Http\Controllers\Api\Auth\LoginController@logout');            

        /*API Auth*/ 
        /*************************************************************************************************************/
        $api->group(['middleware' => 'api.auth'], function ($api) {
        /*API Management*/
                $api->get('getRekapAnggota', 'App\Http\Controllers\Api\ManagementController@getRekapAnggota');
            /*Anggota Importir*/
                $api->get('getDetailVerifikasiImportir/{id}', 'App\Http\Controllers\Api\ManagementController@detailVerifikasiImportir');
                $api->post('submitVerifikasiImportir', 'App\Http\Controllers\Api\ManagementController@submitVerifikasiImportir');
            /*Anggota Importir*/

            /*Anggota Eksportir*/
                $api->get('getDetailVerifikasiEksportir/{id}', 'App\Http\Controllers\Api\ManagementController@detailVerifikasiEksportir');
                $api->post('submitVerifikasiEksportir', 'App\Http\Controllers\Api\ManagementController@submitVerifikasiEksportir');
            /*Anggota Eksportir*/  
            
            /*Management Product*/
                $api->post('getProdukList', 'App\Http\Controllers\Api\ProductController@findProductById');
            /*Management Product*/

        });
            /*Contact Us*/
            $api->post('contactUs', 'App\Http\Controllers\Api\ManagementNoAuthController@contactUs');
            /*Contact Us*/
                 
        /*API Management*/
});
