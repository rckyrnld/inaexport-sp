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
    Route::post('getRekapAnggotaEks', 'Api\Admin\ManagementController@getRekapAnggotaEks');

    Route::post('getDetailVerifikasiImportir', 'Api\Admin\ManagementController@detailVerifikasiImportir');
    Route::post('submitVerifikasiImportir', 'Api\Admin\ManagementController@submitVerifikasiImportir');

    Route::post('getDetailVerifikasiEksportir', 'Api\Admin\ManagementController@detailVerifikasiEksportir');
    Route::post('submitVerifikasiEksportir', 'Api\Admin\ManagementController@submitVerifikasiEksportir');
	
	//Buying Request
	Route::post('list_br_admin', 'Api\Admin\ManagementController@list_br_admin');
	Route::post('list_br_join', 'Api\Admin\ManagementController@list_br_join');
	Route::post('list_br_chat', 'Api\Admin\ManagementController@list_br_chat');
	Route::post('br_admin_save', 'Api\Admin\ManagementController@br_admin_save');
	
	//Inquiry 
	Route::post('list_inquiry_admin', 'Api\Admin\InquiryController@list_inquiry_admin');
	Route::post('insert_inquiry_admin', 'Api\Admin\InquiryController@store');
	Route::post('list_inquiry_broadcast', 'Api\Admin\InquiryController@list_inquiry_broadcast');
	Route::post('list_inquiry_hc', 'Api\Admin\InquiryController@list_inquiry_hc');
	Route::post('verif_inquiry_admin', 'Api\Admin\InquiryController@verif_inquiry_admin');
	
    // LIST COMPANY
    Route::post('listCompany', 'Api\Admin\ManagementController@listCompany');

    // PRODUCT BY EKS
    Route::post('listProductCompany', 'Api\Admin\ManagementController@listProductCompany');
    Route::post('activate_product', 'Api\Admin\ManagementController@activate_product');

    // DETAIL EKS
    Route::post('detailCompany', 'Api\Admin\ManagementController@detailCompany');
    Route::post('searchcompany', 'Api\Admin\EksreportController@searchcompany');
    Route::post('searchproduct', 'Api\Admin\EksreportController@searchproduct');
	
	//Management User
	Route::post('list_eksportir', 'Api\Admin\ManagementController@list_eksportir');
	Route::post('list_importir', 'Api\Admin\ManagementController@list_importir');
	
});

Route::group(['middleware' => ['api', 'manage_token:api_user,2|3']], function () {
//Greed
	Route::post('count_br_chat', 'Api\User\BuyingreqController@count_br_chat');
	Route::post('count_tkt_chat', 'Api\User\ManagementUserController@count_tkt_chat');
	Route::post('count_inq_chat', 'Api\User\ManagementUserController@count_inq_chat');
	Route::post('count_notif_bb', 'Api\User\ManagementUserController@count_notif_bb');
	Route::post('count_notif_all', 'Api\User\ManagementUserController@count_notif_all');

//End Greed

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
    Route::post('trainingInterest', 'Api\User\ManagementUserController@trainingInterest');

    //event
    Route::post('joinEvent', 'Api\User\ManagementUserController@joinEvent');
    Route::post('eventInterest', 'Api\User\ManagementUserController@eventInterest');

    //tiketing
    Route::post('createTicket', 'Api\User\ManagementUserController@createTicketing');
    Route::post('data_ticketing', 'Api\User\ManagementUserController@data_ticketing');
    Route::post('vchat', 'Api\User\ManagementUserController@vchat');
    Route::post('sendchat', 'Api\User\ManagementUserController@sendchat');
    Route::post('destroytiketing', 'Api\User\ManagementUserController@destroytiketing');

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
    Route::post('br_importir_brodcast', 'Api\User\BuyingreqController@br_importir_bc');
    Route::post('br_importir_lc', 'Api\User\BuyingreqController@br_importir_lc');
    Route::post('br_konfirm', 'Api\User\BuyingreqController@br_konfirm');
    Route::post('eks_br_chat', 'Api\User\BuyingreqController@eks_br_chat');
    Route::post('simpanchatbr', 'Api\User\BuyingreqController@simpanchatbr');
    Route::post('uploadpop', 'Api\User\BuyingreqController@uploadpop');

    Route::post('ekslistbr', 'Api\User\BuyingreqController@ekslistbr');
    Route::post('eksjoinbr', 'Api\User\BuyingreqController@eksjoinbr');
    Route::post('br_save_join', 'Api\User\BuyingreqController@br_save_join');
    Route::post('br_deal', 'Api\User\BuyingreqController@br_deal');

    //transaksi
    Route::post('getTransaksi', 'Api\User\ManagementUserController@getTransaksi');
    Route::post('detailTransaksi', 'Api\User\ManagementUserController@detailTransaksi');
    Route::post('save_trx', 'Api\User\ManagementUserController@save_trx');

    //notif
    Route::post('getNotif', 'Api\User\ManagementUserController@getNotif');
    Route::post('updateNotif', 'Api\User\ManagementUserController@updateNotif');
});
Route::namespace('Api')->group(function () {
    /*Contact Us*/
    Route::post('contactUs', 'ManagementNoAuthController@contactUs');
    /*Contact Us*/
	/* Slide Content */
    Route::get('getslide', 'ProductNonAuthController@getslide');
	/* end slide content */
	/* Event */
	Route::get('event_suggest', 'EventNonAuthController@event_suggest');
	Route::post('event_list', 'EventNonAuthController@event_list');
	/*end event */
	
    Route::post('browseProdukFe', 'ProductNonAuthController@browseProduct');
    Route::post('FindProdukByKategori', 'ProductNonAuthController@findProduct');
    Route::post('browseProdukFeByKategori', 'ProductNonAuthController@browseProductByKategori');
    Route::get('getKategori', 'ProductNonAuthController@findKategori');
    Route::post('detailProdukFe', 'ProductNonAuthController@detailProduk');
    Route::get('getImageProduk/{id}/{image}', 'ProductNonAuthController@getImageProduk');
    Route::get('getRandomProduct', 'ProductNonAuthController@getRandomProduct');
    Route::get('getParentCategory', 'ProductNonAuthController@getKategorina');
    Route::post('getLevel1Category', 'ProductNonAuthController@getSubKategorina');
    Route::post('getLevel2Category', 'ProductNonAuthController@getSubKategorina2');
    Route::get('getprodukBaru', 'ProductNonAuthController@getprodukBaru');
    Route::post('browseProductListBynameAndKategori', 'ProductNonAuthController@browseProductDetailBynameAndKategori');
    Route::post('suggestProductkategorisearch', 'ProductNonAuthController@browseProductBynameAndKategori');
    Route::get('suggestProductnamesearch', 'ProductNonAuthController@suggestProductname');

    //training
    Route::get('getTrainingall', 'TrainingNonAuthController@browseTraining');
    Route::post('getDetailTrainingID', 'TrainingNonAuthController@findTrainingById');

    //register
    Route::post('registerExp', 'ManagementNoAuthController@RegisterExp');
    Route::post('registerImp', 'ManagementNoAuthController@RegisterImp');
    Route::post('checkEmail', 'ManagementNoAuthController@checkEmail');

    //country province
    Route::get('getCountry', 'ManagementNoAuthController@getCountry');
    Route::get('getProvince', 'ManagementNoAuthController@getProvince');
    Route::get('getCategory', 'ManagementNoAuthController@getKategori');
    Route::post('getSub', 'ManagementNoAuthController@getSub');
    //Filter
    Route::get('getCategoryFilter', 'ManagementNoAuthController@getKategoriFilter');
    Route::get('getCountryFilter', 'ManagementNoAuthController@getCountryFilter');

    //RC
    Route::get('getResearchc', 'ManagementNoAuthController@getResearchchor');
    Route::post('getResearchc', 'ManagementNoAuthController@getResearchc');

    //tracking
    Route::get('getDataTracking', 'ManagementNoAuthController@getDataTracking');
    Route::post('tracking', 'TrackingController@tracking');

    //event
    Route::get('getDataEvent', 'ManagementNoAuthController@getEvent');

    //hscode
    Route::get('getHscode', 'ManagementNoAuthController@getHscode');
    Route::get('getHscodeFilter', 'ManagementNoAuthController@getHscodeFilter');

    // Populer Categories
    Route::get('populerCategories', 'ProductNonAuthController@populerCategories');

    // Get Product By Categories
    Route::post('productByCategories', 'ProductNonAuthController@productByCategories');

});
// });
