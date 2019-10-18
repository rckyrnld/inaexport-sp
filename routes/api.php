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
    // $api->group(['prefix' => 'auth'], function ($api) {
        $api->get('getRekapAnggota', 'App\Http\Controllers\Api\VerifikasiAnggotaController@index');
    //Anggota Importir
        $api->get('getDetailVerifikasiImportir/{id}', 'App\Http\Controllers\Api\VerifikasiAnggotaController@detailVerifikasiImportir');
        $api->post('submitVerifikasiImportir', 'App\Http\Controllers\Api\VerifikasiAnggotaController@submitVerifikasiImportir');
    //Anggota Eksportir
        $api->get('getDetailVerifikasiEksportir/{id}', 'App\Http\Controllers\Api\VerifikasiAnggotaController@detailVerifikasiEksportir');
        $api->post('submitVerifikasiEksportir', 'App\Http\Controllers\Api\VerifikasiAnggotaController@submitVerifikasiEksportir');
    
        // });
});
