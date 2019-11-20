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

Route::group(['middleware' => ['api', 'manage_token:api_user,2|3']], function () {
    Route::post('getProdukList', 'Api\User\ProductController@findProductById');
    Route::post('browseProduk', 'Api\User\ProductController@browseProduct');

    Route::post('insertProduk', 'Api\User\ProductController@insertProduct');
    Route::post('updateProduk', 'Api\User\ProductController@updateProduct');
    Route::post('deleteProduk', 'Api\User\ProductController@deleteProduct');
    Route::post('detailProdukById', 'Api\User\ProductController@detailProduk');

    //profile
    Route::post('detailProfileExp', 'Api\User\ProfileController@findProfileExp');
    Route::post('detailFotoExp', 'Api\User\ProfileController@findImageExp');
    Route::post('updateDataExp', 'Api\User\ProfileController@updateProfilExp');

    Route::post('detailProfileImp', 'Api\User\ProfileController@findProfileImp');
    Route::post('detailFotoImp', 'Api\User\ProfileController@findImageimp');
    Route::post('updateDataImp', 'Api\User\ProfileController@updateProfilImp');

    //training
    Route::post('joinTraining', 'Api\User\ManagementUserController@joinTraining');

    //event
    Route::post('joinEvent', 'Api\User\ManagementUserController@joinEvent');

    //tiketing
    Route::post('createTicket', 'Api\User\ManagementUserController@createTicketing');

    //RC
    Route::post('downloadResearch', 'Api\User\ManagementUserController@downloadResearch');

    //inquiry
    //imp
    Route::post('getInquiry', 'Api\User\InquiryController@getListinquiry');
    Route::post('searchInquiry', 'Api\User\InquiryController@searchListinquiry');
    Route::post('simpanInquiryImportir', 'Api\User\InquiryController@store');
    Route::post('verifikasi_inquiryImportir', 'Api\User\InquiryController@verifikasi_inquiry');
    Route::post('chatImportir', 'Api\User\InquiryController@masukchattingImp');
    Route::post('sendchatImportir', 'Api\User\InquiryController@sendChatimp');

    Route::post('sendchatFile', 'Api\User\InquiryController@fileChat');

    //eks
    Route::post('getInquiryeks', 'Api\User\InquiryController@getDataeks');
    Route::post('joinedEks', 'Api\User\InquiryController@joined');
    Route::post('acceptjoinedEks', 'Api\User\InquiryController@accept_chat');
    Route::post('chatEksportir', 'Api\User\InquiryController@masukchattingEks');
    Route::post('sendchatEksportir', 'Api\User\InquiryController@sendChatEks');
    Route::post('dealingEksportir', 'Api\User\InquiryController@dealing');
    //inquiry end
    //BR
    Route::post('impmasukbr', 'Api\User\BuyingreqController@impmasukbr');
    Route::post('impdata_br', 'Api\User\BuyingreqController@impdata_br');
    Route::post('br_importir_save', 'Api\User\BuyingreqController@br_importir_save');
    Route::post('br_importir_bc', 'Api\User\BuyingreqController@br_importir_bc');

    Route::post('ekslistbr', 'Api\User\BuyingreqController@ekslistbr');
    Route::post('eksjoinbr', 'Api\User\BuyingreqController@eksjoinbr');



});
Route::namespace('Api')->group(function () {
    /*Contact Us*/
    Route::post('contactUs', 'ManagementNoAuthController@contactUs');
    /*Contact Us*/

    Route::get('browseProdukFe', 'ProductNonAuthController@browseProduct');
    Route::post('browseProdukFeByKategori', 'ProductNonAuthController@browseProductByKategori');
    Route::get('getKategori', 'ProductNonAuthController@findKategori');
    Route::post('detailProdukFe', 'ProductNonAuthController@detailProduk');
    Route::get('getImageProduk/{id}/{image}', 'ProductNonAuthController@getImageProduk');
    Route::get('getRandomProduct', 'ProductNonAuthController@getRandomProduct');
    Route::get('getprodukBaru', 'ProductNonAuthController@getprodukBaru');

    //training
    Route::get('getTrainingall', 'TrainingNonAuthController@browseTraining');
    Route::post('getDetailTrainingID', 'TrainingNonAuthController@findTrainingById');

    //register
    Route::post('registerExp', 'ManagementNoAuthController@RegisterExp');
    Route::post('registerImp', 'ManagementNoAuthController@RegisterImp');

    //country province
    Route::get('getCountry', 'ManagementNoAuthController@getCountry');
    Route::get('getProvince', 'ManagementNoAuthController@getProvince');

    //RC
    Route::get('getResearchc', 'ManagementNoAuthController@getResearchchor');

    //tracking
    Route::get('getDataTracking', 'ManagementNoAuthController@getDataTracking');
    Route::post('tracking', 'TrackingController@tracking');

    //event
    Route::get('getDataEvent', 'ManagementNoAuthController@getEvent');
});
// });
