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
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});
// Route::get('/', function () {
//     return redirect('/front_end');
// });
Route::get('switch/{locale}', function ($locale) {
    App::setLocale($locale);
});
Route::get('/registrasi_pembeli', 'RegistrasiController@registrasi_pembeli');
Route::get('/forget_a', 'RegistrasiController@forget_a');
Route::get('/gantipass1/{id}', 'RegistrasiController@gantipass1');
Route::get('/gantipass2/{id}', 'RegistrasiController@gantipass2');
Route::post('/updatepass1/{id}', 'RegistrasiController@updatepass1');
Route::post('/updatepass2/{id}', 'RegistrasiController@updatepass2');
Route::post('/resetpass', 'RegistrasiController@resetpass');
Route::post('/api-tracking/', 'Api\TrackingController@tracking')->name('api.tracking');
Route::get('/check', 'UserController@userOnlineStatus');
Route::get('/check2', 'UserEksmpController@usereksmpOnlineStatus');
Route::get('/pendapatan_list', 'RekapPendapatanController@index');
Route::get('/exportpendapatanall', 'RekapPendapatanController@exportpendapatanall');
Route::get('/cetakrc', 'RekapPendapatanController@cetakrc');
Route::get('/exportpendapatandetail/{id}', 'RekapPendapatanController@exportpendapatandetail');
Route::get('/detailpendapatan/{id}', 'RekapPendapatanController@detailpendapatan');

Route::namespace('FrontEnd')->group(function () {
    /* Created by Meidiyanah */
    //Transaction
    Route::get('/front_end/list_transaction', 'TransactionFrontController@index');
    Route::get('/front_end/transaction_getdata', 'TransactionFrontController@datanya')->name('front.datatables.transaction');
    //Product
    Route::get('/', 'FrontController@index');
    Route::get('/front_end/list_product', 'FrontController@list_product');
    Route::get('/front_end/getCategory', 'FrontController@getCategory')->name('front.product.getCategory');
    Route::get('/front_end/list_product/category/{id}', 'FrontController@product_category')->name('front.product.product_category');
    Route::get('/front_end/getManufactur', 'FrontController@getManufactur')->name('front.product.getManufactur');
    Route::get('/front_end/product/{id}', 'FrontController@view_product');
    //Inquiry Pembeli
    Route::get('/front_end/inquiry_product/{id}', 'InquiryFrontController@create');
    Route::post('front_end/inquiry_act/{id}', 'InquiryFrontController@store');
    Route::get('/front_end/ver_inquiry/{id}', 'InquiryFrontController@verifikasi_inquiry');
    Route::get('/front_end/chat_inquiry/{id}', 'InquiryFrontController@chatting')->name('front.inquiry.chatting');
    Route::post('/front_end/inquiry_chatfile/fileChat', 'InquiryFrontController@fileChat')->name('front.inquiry.fileChat');
    Route::get('/front_end/inquiry_chat/sendChat', 'InquiryFrontController@sendChat')->name('front.inquiry.sendChat');
    Route::get('/front_end/view_inquiry/{id}', 'InquiryFrontController@view')->name('front.inquiry.view');
    //Ticketing Support
    //Eksportir
    Route::get('/front_end/ticketing_support', 'TicketingSupportFrontController@create')->name('front.ticket.create');
    Route::post('/front_end/ticketing_support/store', 'TicketingSupportFrontController@store')->name('front.ticket.store');
    Route::get('/front_end/ticketing_support/chatview/{id}', 'TicketingSupportFrontController@vchat')->name('front.ticket.vchat');
    Route::post('/front_end/ticketing_support/sendchat', 'TicketingSupportFrontController@sendchat')->name('front.ticket.sendchat');
    Route::post('/front_end/ticketing_support/sendFilechat', 'TicketingSupportFrontController@sendFilechat')->name('front.ticket.sendchat');
    Route::get('/front_end/ticketing_support/view/{id}', 'TicketingSupportFrontController@view')->name('front.ticket.view');
    Route::get('/front_end/ticketing_support/delete/{id}', 'TicketingSupportFrontController@destroy')->name('front.ticket.delete');
    //History Transaction
    Route::get('/front_end/history', 'HistoryFrontController@index')->name('front.histori.index');
    //Ticketing Support
    Route::get('/front_end/history/ticketing_getdata', 'HistoryFrontController@data_ticketing')->name('front.datatables.ticketing');
    //Inquiry
    Route::get('/front_end/history/inquiry_getdata', 'HistoryFrontController@data_inquiry')->name('front.datatables.inquiry');
    //Buying Request
    Route::get('/front_end/history/br_getdata', 'HistoryFrontController@data_br')->name('front.datatables.br');

    //List Perusahaan (Eksportir)
    Route::get('/front_end/list_perusahaan', 'SuppliersFrontController@list_perusahaan')->name('front.eksportir.index');
    Route::get('/front_end/list_perusahaan/getCategory', 'SuppliersFrontController@getCategory')->name('front.eksportir.getCategory');
    Route::get('/front_end/list_perusahaan/category/{id}', 'SuppliersFrontController@eksportir_category')->name('front.eksportir.category');
    Route::get('/front_end/list_perusahaan/view/{id}', 'SuppliersFrontController@view_eksportir')->name('front.eksportir.view');


    ////////////////////////////////  AeNGeGeA  ///////////////////////////////////////////
    Route::get('/front_end/research-corner', 'FrontController@research_corner');
    Route::get('/front_end/tracking', 'FrontController@tracking');
    Route::get('/about/', 'FrontController@about');
    Route::get('/contact-us', 'FrontController@contact_us');
    Route::post('/contact-us/send', 'FrontController@contact_us_send');
    Route::get('/front_end/service-detail/{id}', 'FrontController@service');
    Route::get('/profile/getCity/{param}', 'ImporterController@getCity')->name('ajax-city');
    Route::get('/profile/', 'ImporterController@profile')->name('profile');
    Route::post('/profile/update/', 'ImporterController@update')->name('profile.update');
    Route::post('/profile/contact_update/', 'ImporterController@contact_update')->name('profile.contact_update');
    Route::post('/product/hot/', 'FrontController@hot')->name('product.hot');
    Route::get('/front_end/test', function () {
        return view('frontend.contoh.content_home');
    });
    ////////////////////////////////  AeNGeGeA  ///////////////////////////////////////////

    /**
     * Createdby Intan Kamelia
     */
    Route::get('/front_end/event', 'FrontController@Event');
    Route::any('/front_end/event/search', 'FrontController@search_event');
    Route::get('/front_end/join_event/{id}', 'FrontController@join_event');
    Route::get('/front_end/gabung_event/{id}', 'FrontController@gabung_event');
    Route::post('/event-interest', 'FrontController@event_interest')->name('event.interest');

    //YOSS
    //Front End TrainingController
    Route::get('/front_end/training', 'FrontController@indexTraining');
    Route::get('frontend/training/search', 'FrontController@indexTrainingSearch');
    Route::post('/training-interest', 'FrontController@training_interest')->name('training.interest');
    //End Training Frontend


});

Route::get('/br_importir_all', 'BRFrontController@br_importir_all');
Route::get('/br_importir', 'BRFrontController@br_importir');
Route::get('/br_importir_add', 'BRFrontController@br_importir_add');
Route::get('/br_importir_detail/{id}', 'BRFrontController@br_importir_detail');
Route::get('/br_importir_lc/{id}', 'BRFrontController@br_importir_lc');
Route::get('/br_importir_chat/{id}/{id2}', 'BRFrontController@br_importir_chat');
Route::get('/br_importir_bc/{id}', 'BRFrontController@br_importir_bc');
Route::get('/br_pw_bc/{id}', 'BRFrontController@br_pw_bc');
Route::get('/br_pw_bcs/{id}', 'BRFrontController@br_pw_bcs');
Route::get('/br_konfirm/{id}/{id2}', 'BRFrontController@br_konfirm');
Route::get('/br_konfirm2/{id}/{id2}', 'BRFrontController@br_konfirm2');
Route::get('/refreshchat/{id}/{id2}', 'BRFrontController@refreshchat');
Route::get('/refreshchat2/{id}/{id2}', 'BRFrontController@refreshchat2');
Route::get('/refreshchat3/{id}/{id2}', 'BRFrontController@refreshchat3');
Route::post('/br_importir_save', 'BRFrontController@br_importir_save');
Route::post('/br_importir_update', 'BRFrontController@br_importir_update');
Route::post('/br_importir_next', 'BRFrontController@br_importir_next');
Route::post('/uploadpop', 'BRFrontController@uploadpop');
Route::post('/uploadpop2', 'BRFrontController@uploadpop2');
Route::get('/ambilbroad/{id}', 'BRFrontController@ambilbroad');
Route::get('/ambilbroad2/{id}', 'BRFrontController@ambilbroad2');
/* Route::get('/registrasi_pembeli/{locale}', function ($locale) {
    App::setLocale($locale);
    return view('auth.register_pembeli');
}); */
Route::post('/simpan_rpembeli', 'RegistrasiController@simpan_rpembeli');
Route::get('/verifypembeli/{id}', 'RegistrasiController@verifypembeli');
 Route::get('/br_getdata2', 'RegistrasiController@data_br2')->name('front.datatables.br2');

Route::get('/registrasi_penjual', 'RegistrasiController@registrasi_penjual');
Route::post('/simpan_rpenjual', 'RegistrasiController@simpan_rpenjual');
Route::get('/verifypenjual/{id}', 'RegistrasiController@verifypenjual');

Route::post('/loginei', 'LoginEIController@loginei')->name('loginei.login');
Route::get('/admin', 'RegistrasiController@loginadmin');
Route::get('/pilihregister', 'RegistrasiController@pilihregister');
Route::get('/cekmail/{id}', 'RegistrasiController@cekmail');


//////////////////////////////////// END FRONTEND ////////////////////////////////////////////////////////////
//////////////////////////////////// START BACKEND ////////////////////////////////////////////////////////////

Route::get('/login', 'HomeController@index');
Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard-seller', 'DashboardEksportirController@index');
//Verify User 
Route::get('ceknpwp', 'VerifyuserController@ceknpwp');
Route::get('/bacanotif/{id}', 'VerifyuserController@bacanotif');
Route::get('/verifyuser', 'VerifyuserController@index');
Route::get('/geteksportir', 'VerifyuserController@geteksportir');
Route::get('/verifyimportir', 'VerifyuserController@index2');
Route::get('/hapuseksportir/{id}', 'VerifyuserController@hapuseksportir');
Route::get('/reseteksportir/{id}', 'VerifyuserController@reseteksportir');
Route::get('/hapusimportir/{id}', 'VerifyuserController@hapusimportir');
Route::get('/resetimportir/{id}', 'VerifyuserController@resetimportir');
Route::get('/getimportir', 'VerifyuserController@getimportir');
Route::get('/profilperwakilan', 'VerifyuserController@index3');
Route::get('/getpw', 'VerifyuserController@getpw');
Route::get('/tambahperwakilan', 'VerifyuserController@tambahperwakilan');
Route::get('/detailverify/{id}', 'VerifyuserController@detailverify');
Route::get('/hapusperwakilan/{id}', 'VerifyuserController@hapusperwakilan');
Route::get('/editperwakilan/{id}', 'VerifyuserController@editperwakilan');
Route::get('/saveverify/{id}', 'VerifyuserController@saveverify');
Route::get('/profil/{id}/{id2}', 'VerifyuserController@profil');
Route::get('/profil2/{id}/{id2}', 'VerifyuserController@profil2');
Route::post('/simpan_profil', 'VerifyuserController@simpan_profil');
Route::post('/simpan_profil2', 'VerifyuserController@simpan_profil2');
Route::post('/simpanperwakilan', 'VerifyuserController@simpanperwakilan');
Route::post('/updateperwakilan', 'VerifyuserController@updateperwakilan');
Route::post('/simpan_kontak', 'VerifyuserController@simpan_kontak');

// Group
Route::resource('/group', 'UM\GroupController');
Route::post('/group_save', 'UM\GroupController@store');
Route::get('/group_edit/{id}', 'UM\GroupController@edit');
Route::post('/group_update/{id}', 'UM\GroupController@update');
Route::get('/group_delete/{id}', 'UM\GroupController@destroy');

//user
Route::resource('/users', 'UM\UsersController');
Route::post('/user_save', 'UM\UsersController@store');
Route::get('/user_edit/{id}', 'UM\UsersController@edit');
Route::get('/getem/{id}', 'UM\UsersController@getem');
Route::post('/user_update/{id}', 'UM\UsersController@update');
Route::get('/user_delete/{id}', 'UM\UsersController@destroy');

//menu
Route::resource('/menus', 'UM\MenuController');
Route::get('/menu_add', 'UM\MenuController@create');
Route::post('/menu_save', 'UM\MenuController@store');
Route::get('/menu_edit/{id}', 'UM\MenuController@edit');
Route::post('/menu_update/{id}', 'UM\MenuController@update');
Route::get('/menu_delete/{id}', 'UM\MenuController@destroy');

Route::get('/submenu_add/{id}', 'UM\MenuController@create_submenu');
Route::post('/submenu_save', 'UM\MenuController@store_submenu');
Route::get('/submenu_edit/{id}', 'UM\MenuController@edit_submenu');
Route::post('/submenu_update/{id}', 'UM\MenuController@update_submenu');

//permissions
Route::resource('/permissions', 'UM\PermissionsController');
Route::post('/permission_save', 'UM\PermissionsController@store');
Route::get('/permission_edit/{id}', 'UM\PermissionsController@edit');
Route::post('/permission_update/{id}', 'UM\PermissionsController@update');
Route::get('/permission_delete/{id}', 'UM\PermissionsController@destroy');

//buy request 
Route::resource('/br_list', 'BuyingRequestController');
Route::get('/getcsc0', 'BuyingRequestController@getcsc0');
Route::get('/getcsc', 'BuyingRequestController@getcsc');
Route::get('/getcsc3', 'BuyingRequestController@getcsc3');
Route::get('/simpanchatbr/{id}/{id2}/{id3}/{id4}/{id5}/{id6}', 'BuyingRequestController@simpanchatbr');
Route::get('/br_add', 'BuyingRequestController@add');
Route::get('/br_pw_lc/{id}', 'BuyingRequestController@br_pw_lc');
Route::get('/br_pw_dt/{id}', 'BuyingRequestController@br_pw_dt');
Route::get('/br_join/{id}', 'BuyingRequestController@br_join');
Route::get('/br_pw_chat/{id}', 'BuyingRequestController@br_pw_chat');
Route::get('/br_chat/{id}', 'BuyingRequestController@br_chat');
Route::get('/br_deal/{id}/{id2}/{id3}', 'BuyingRequestController@br_deal');
Route::get('/br_trx/{id}/{id2}', 'BuyingRequestController@br_trx');
Route::get('/br_trx2/{id}', 'BuyingRequestController@br_trx2');
Route::get('/br_save_join/{id}', 'BuyingRequestController@br_save_join');
Route::get('/ambilt2/{id}', 'BuyingRequestController@ambilt2');
Route::get('/ambilt3/{id}', 'BuyingRequestController@ambilt3');
Route::post('/br_save', 'BuyingRequestController@br_save');
Route::post('/br_save_trx', 'BuyingRequestController@br_save_trx');
Route::get('/show_all_notif', 'BuyingRequestController@show_all_notif');
Route::get('/unread_all_notif', 'BuyingRequestController@unread_all_notif');

//trx 
Route::resource('/trx_list', 'TrxController');
Route::get('/input_transaksi/{id}', 'TrxController@input_transaksi');
Route::post('/save_trx', 'TrxController@save_trx');
Route::get('/br_getdata3', 'TrxController@data_br3')->name('front.datatables.br3');
Route::get('/br_getdata4', 'TrxController@data_br4')->name('front.datatables.br4');
Route::get('/detailtrx/{id}', 'TrxController@detailtrx');
Route::get('/allgr/{id}', 'TrxController@allgr');
Route::get('/joineks/{id}/{id2}', 'TrxController@joineks');
Route::get('/caritab/{id}/{id2}', 'TrxController@caritab');
Route::get('/cetaktrx/{id}/{id2}', 'TrxController@cetaktrx');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/gantipass', 'HomeController@gantipass');
Route::post('/updatepass', 'HomeController@updatepass');

Route::get('/directory/', 'DirectoryController@index')->name('directory.index');
Route::post('/directory/getData/', 'DirectoryController@getData')->name('directory.getData');
Route::get('/directory/view/{id}', 'DirectoryController@view')->name('directory.view');

Route::get('/user-guide/', 'HomeController@user_guide')->name('user-guide.index');
Route::get('/user-guide/getData', 'HomeController@user_guide_data')->name('user-guide.getData');
Route::post('/user-guide/update', 'HomeController@user_guide_update')->name('user-guide.update');

Route::namespace('Master')->group(function () {
// Angga Start
    //Master Country
    Route::prefix('master-country')->group(function () {
        Route::name('master.country.')->group(function () {
		    Route::get('/', 'MasterCountryController@index')->name('index');
		    Route::get('/getData/', 'MasterCountryController@getData')->name('getData');
		    Route::get('/create/', 'MasterCountryController@create')->name('create');
		    Route::get('/check-kode/', 'MasterCountryController@check')->name('kode');
		    Route::get('/edit/{id}', 'MasterCountryController@edit')->name('edit');
		    Route::get('/view/{id}', 'MasterCountryController@view')->name('view');
		    Route::post('/store/{param}', 'MasterCountryController@store')->name('store');
		    Route::get('/destroy/{id}', 'MasterCountryController@destroy')->name('destroy');
    		Route::get('/export/', 'MasterCountryController@export')->name('export');
        });
    });

    //Master City
    Route::prefix('master-city')->group(function () {
        Route::name('master.city.')->group(function () {
		    Route::get('/', 'MasterCityController@index')->name('index');
		    Route::get('/getData/', 'MasterCityController@getData')->name('getData');
		    Route::get('/create/', 'MasterCityController@create')->name('create');
		    Route::get('/edit/{id}', 'MasterCityController@edit')->name('edit');
		    Route::get('/view/{id}', 'MasterCityController@view')->name('view');
		    Route::post('/store/{param}', 'MasterCityController@store')->name('store');
		    Route::get('/destroy/{id}', 'MasterCityController@destroy')->name('destroy');
		    Route::get('/export/', 'MasterCityController@export')->name('export');
        });
    });

    //Master Province
    Route::prefix('master-province')->group(function () {
        Route::name('master.province.')->group(function () {
		    Route::get('/', 'MasterProvinceController@index')->name('index');
		    Route::get('/getData/', 'MasterProvinceController@getData')->name('getData');
		    Route::get('/create/', 'MasterProvinceController@create')->name('create');
		    Route::get('/check-kode/', 'MasterProvinceController@check')->name('kode');
		    Route::get('/edit/{id}', 'MasterProvinceController@edit')->name('edit');
		    Route::get('/view/{id}', 'MasterProvinceController@view')->name('view');
		    Route::post('/store/{param}', 'MasterProvinceController@store')->name('store');
		    Route::get('/destroy/{id}', 'MasterProvinceController@destroy')->name('destroy');
		    Route::get('/export/', 'MasterProvinceController@export')->name('export');
    	});
    });

    //Master Port
    Route::prefix('master-port')->group(function () {
        Route::name('master.port.')->group(function () {
		    Route::get('/', 'MasterPortController@index')->name('index');
		    Route::get('/getData/', 'MasterPortController@getData')->name('getData');
		    Route::get('/create/', 'MasterPortController@create')->name('create');
		    Route::get('/check-kode/', 'MasterPortController@check')->name('kode');
		    Route::get('/edit/{id}', 'MasterPortController@edit')->name('edit');
		    Route::get('/view/{id}', 'MasterPortController@view')->name('view');
		    Route::post('/store/{param}', 'MasterPortController@store')->name('store');
		    Route::get('/destroy/{id}', 'MasterPortController@destroy')->name('destroy');
		    Route::get('/export/', 'MasterPortController@export')->name('export');
    	});
    });
// Angga End
});

Route::namespace('Management')->group(function () {
// Angga Start
    //Management Category Product
	Route::prefix('management/category-product')->group(function () {
        Route::name('management.category-product.')->group(function () {
		    Route::get('/', 'CategoryProductController@index')->name('index');
		    Route::get('/getData/', 'CategoryProductController@getData')->name('getData');
		    Route::get('/create/', 'CategoryProductController@create')->name('create');
		    Route::get('/edit/{id}', 'CategoryProductController@edit')->name('edit');
		    Route::get('/view/{id}', 'CategoryProductController@view')->name('view');
		    Route::get('/level_2/', 'CategoryProductController@level_2')->name('level2');
		    Route::post('/store/{param}', 'CategoryProductController@store')->name('store');
		    Route::get('/destroy/{id}', 'CategoryProductController@destroy')->name('destroy');
            Route::post('/home/', 'CategoryProductController@home')->name('home');
        });
    });

    //Management Contact Us
    Route::prefix('management/contact-us')->group(function () {
        Route::name('management.contact-us.')->group(function () {
		    Route::get('/', 'DataContactUsController@index')->name('index');
		    Route::get('/getData/', 'DataContactUsController@getData')->name('getData');
		    Route::get('/view/{id}', 'DataContactUsController@view')->name('view');
		    Route::get('/destroy/{id}', 'DataContactUsController@destroy')->name('destroy');
        });
    });
// Angga End
});

Route::namespace('ResearchCorner')->group(function () {
// Angga Start
    Route::prefix('admin/research-corner')->group(function () {
        Route::name('admin.research-corner.')->group(function () {
            Route::get('/', 'AdminResearchController@index')->name('index');
            Route::get('/getData/', 'AdminResearchController@getData')->name('getData');
            Route::get('/getDataDownload/{id}', 'AdminResearchController@getDataDownload')->name('getDataDownload');
            Route::get('/create/', 'AdminResearchController@create')->name('create');
            Route::post('/store/{param}', 'AdminResearchController@store')->name('store');
            Route::get('/edit/{id}', 'AdminResearchController@edit')->name('edit');
            Route::get('/view/{id}', 'AdminResearchController@view')->name('view');
            Route::get('/destroy/{id}', 'AdminResearchController@destroy')->name('destroy');
            Route::post('/broadcast/', 'AdminResearchController@broadcast')->name('broadcast');
            Route::get('/hscode', 'AdminResearchController@hscode')->name('hscode');
        });
    });
    Route::prefix('perwakilan/research-corner')->group(function () {
        Route::name('perwakilan.research-corner.')->group(function () {
            Route::get('/', 'PerwakilanResearchController@index')->name('index');
            Route::get('/getData/', 'PerwakilanResearchController@getData')->name('getData');
            Route::get('/getDataDownload/{id}', 'PerwakilanResearchController@getDataDownload')->name('getDataDownload');
            Route::get('/create/', 'PerwakilanResearchController@create')->name('create');
            Route::post('/store/{param}', 'PerwakilanResearchController@store')->name('store');
            Route::get('/edit/{id}', 'PerwakilanResearchController@edit')->name('edit');
            Route::get('/view/{id}', 'PerwakilanResearchController@view')->name('view');
            Route::get('/destroy/{id}', 'PerwakilanResearchController@destroy')->name('destroy');
            Route::post('/broadcast/', 'PerwakilanResearchController@broadcast')->name('broadcast');
        });
    });
    Route::prefix('research-corner')->group(function () {
        Route::name('research-corner.')->group(function () {
            Route::get('/list/', 'ResearchCornerController@index')->name('index');
            Route::get('/getData/', 'ResearchCornerController@getData')->name('getData');
            Route::get('/read/{id}', 'ResearchCornerController@read')->name('view');
            Route::get('/download/', 'ResearchCornerController@download')->name('download');
        });
    });
// Angga End
});


/**
 * Createdby Intan Kamelia
 */
Route::namespace('Event')->prefix('event')->group(function () {
    Route::get('/', 'EventController@index');
    Route::get('/comodity', 'EventController@comodity')->name('event.comodity');
    Route::get('/create', 'EventController@create');
    Route::post('/store', 'EventController@store');
    Route::get('/edit/{id}', 'EventController@edit');
    Route::post('/update/{id}', 'EventController@update');
    Route::get('/delete/{id}', 'EventController@delete');
    Route::get('/show_company/{id}', 'EventController@show_company');
    Route::get('/show/read/{id}', 'EventController@show');
    Route::get('/show_detail/{id}', 'EventController@show_detail');
    Route::get('/show_detail/front/{id}', 'EventController@show_detail');
    Route::any('/search', 'EventController@search');
    Route::any('/search_eksportir', 'EventController@search_eksportir');
    Route::get('/getDataInterest/{id}', 'EventController@getDataInterest')->name('event.getDataInterest');

    Route::post('/getEventOrg', 'EventController@getEventOrg');
    Route::post('/getEventPlace', 'EventController@getEventPlace');
		Route::post('/update_status_join', 'EventController@updatestatjoin');
		Route::post('/update_status_ver', 'EventController@updatestatver');
		Route::post('/store_company', 'EventController@store_company');
		Route::post('/update_status_company', 'EventController@updatestatcompany');

});


/////////////////////////////////////////ILYAS START//////////////////////////////////////////////////////////////////////////////////
Route::namespace('Eksportir')->prefix('eksportir')->group(function () {
    //admin all
    Route::get('/admin', 'AnnualController@indexadmin')->name('eksportir.indexadmin');
    Route::get('/getreporteksportir', 'AnnualController@getreporteksportir')->name('datatables.reporteksportir');
    Route::get('/listeksportir/{id}', 'AnnualController@listeksportir');

    //Annual SALES USER
    Route::get('/annual_sales', 'AnnualController@index')->name('annual_sales.index');
    Route::get('/tambah_annual', 'AnnualController@tambah');
    Route::post('/annual_save', 'AnnualController@store');
    Route::get('/sales_getdata', 'AnnualController@datanya')->name('datatables.sales');
    Route::get('/sales_edit/{id}', 'AnnualController@edit')->name('sales.detail');
    Route::get('/sales_view/{id}', 'AnnualController@view')->name('sales.view');
    Route::get('/sales_delete/{id}', 'AnnualController@delete')->name('sales.delete');
    Route::post('/sales_update', 'AnnualController@update');

    //ADMIN
    Route::get('/annual_sales_admin/{id}', 'AnnualController@indexadminannualsales')->name('annual_sales.indexadmin');
    Route::get('/sales_getdata_admin/{id}', 'AnnualController@datanyaadmin');

    //Brand USER
    Route::get('/brand', 'BrandController@index')->name('brand.index');
    Route::get('/tambah_brand', 'BrandController@tambah');
    Route::post('/brand_save', 'BrandController@store');
    Route::get('/brand_getdata', 'BrandController@datanya')->name('datatables.brand');
    Route::get('/brand_edit/{id}', 'BrandController@edit')->name('brand.detail');
    Route::get('/brand_view/{id}', 'BrandController@view')->name('brand.view');
    Route::get('/brand_delete/{id}', 'BrandController@delete')->name('brand.delete');
    Route::post('/brand_update', 'BrandController@update');

    //ADMIN
    Route::get('/brand_admin/{id}', 'BrandController@indexadmin')->name('brand.indexadmin');
    Route::get('/brand_getdata_admin/{id}', 'BrandController@datanyaadmin')->name('datatables.brandadmin');

    //country patern brand
    Route::get('/country_patern_brand', 'CountryPaternBrandController@index')->name('country_patern_brand.index');
    Route::get('/tambah_country_patern_brand', 'CountryPaternBrandController@tambah');
    Route::post('/country_patern_brand_save', 'CountryPaternBrandController@store');
    Route::get('/country_patern_brand_getdata', 'CountryPaternBrandController@datanya')->name('datatables.country_patern_brand');
    Route::get('/country_patern_brand_edit/{id}', 'CountryPaternBrandController@edit')->name('country_patern_brand.detail');
    Route::get('/country_patern_brand_view/{id}', 'CountryPaternBrandController@view')->name('country_patern_brand.view');
    Route::get('/country_patern_brand_delete/{id}', 'CountryPaternBrandController@delete')->name('country_patern_brand.delete');
    Route::post('/country_patern_brand_update', 'CountryPaternBrandController@update');

    //ADMIN
    Route::get('/country_patern_brand_admin/{id}', 'CountryPaternBrandController@indexadmin')->name('country_patern_brand.indexadmin');
    Route::get('/country_patern_brand_getdata_admin/{id}', 'CountryPaternBrandController@datanyaadmin')->name('datatables.country_patern_brandadmin');

    //production capacity
    Route::get('/product_capacity', 'ProcapController@index')->name('brand.index');
    Route::get('/tambah_procap', 'ProcapController@tambah');
    Route::post('/procap_save', 'ProcapController@store');
    Route::get('/procap_getdata', 'ProcapController@datanya')->name('datatables.procap');
    Route::get('/procap_edit/{id}', 'ProcapController@edit')->name('procap.detail');
    Route::get('/procap_view/{id}', 'ProcapController@view')->name('procap.view');
    Route::get('/procap_delete/{id}', 'ProcapController@delete')->name('procap.delete');
    Route::post('/procap_update', 'ProcapController@update');

    //ADMIN
    Route::get('/product_capacity_admin/{id}', 'ProcapController@indexadmin')->name('product_capacity.indexadmin');
    Route::get('/product_capacity_getdata_admin/{id}', 'ProcapController@datanyaadmin')->name('datatables.product_capacity');


    //contact USER
    Route::get('/contact', 'ContactController@index')->name('contact.index');
    Route::get('/tambah_contact', 'ContactController@tambah');
    Route::post('/contact_save', 'ContactController@store');
    Route::get('/contact_getdata', 'ContactController@datanya')->name('datatables.contact');
    Route::get('/contact_edit/{id}', 'ContactController@edit')->name('contact.detail');
    Route::get('/contact_view/{id}', 'ContactController@view')->name('contact.view');
    Route::get('/contact_delete/{id}', 'ContactController@delete')->name('contact.delete');
    Route::post('/contact_update', 'ContactController@update');

    //ADMIN
    Route::get('/contact_admin/{id}', 'ContactController@indexadmin')->name('contact.indexadmin');
    Route::get('/contact_getdata_admin/{id}', 'ContactController@datanyaadmin')->name('datatables.contactadmin');

    //export destination
    Route::get('/export_destination', 'ExsdesController@index')->name('exportdes.index');
    Route::get('/tambah_export_destination', 'ExsdesController@tambah');
    Route::post('/exdes_save', 'ExsdesController@store');
    Route::get('/exdes_getdata', 'ExsdesController@datanya')->name('datatables.exdes');
    Route::get('/exdes_edit/{id}', 'ExsdesController@edit')->name('exdes.detail');
    Route::get('/exdes_view/{id}', 'ExsdesController@view')->name('exdes.view');
    Route::get('/exdes_delete/{id}', 'ExsdesController@delete')->name('exdes.delete');
    Route::post('/exdes_update', 'ExsdesController@update');

    //ADMIN
    Route::get('/export_destination_admin/{id}', 'ExsdesController@indexadmin')->name('export_destination.indexadmin');
    Route::get('/export_destination_getdata_admin/{id}', 'ExsdesController@datanyaadmin');

    //port landing
    Route::get('/portland', 'PortlandController@index')->name('portland.index');
    Route::get('/tambah_portland', 'PortlandController@tambah');
    Route::post('/portland_save', 'PortlandController@store');
    Route::get('/portland_getdata', 'PortlandController@datanya')->name('datatables.portland');
    Route::get('/portland_edit/{id}', 'PortlandController@edit')->name('portland.detail');
    Route::get('/portland_view/{id}', 'PortlandController@view')->name('portland.view');
    Route::get('/portland_delete/{id}', 'PortlandController@delete')->name('portland.delete');
    Route::post('/portland_update', 'PortlandController@update');

    //ADMIN
    Route::get('/portland_admin/{id}', 'PortlandController@indexadmin')->name('export_destination.indexadmin');
    Route::get('/portland_getdata_admin/{id}', 'PortlandController@datanyaadmin');

    //exhibition
    Route::get('/exhibition', 'ExhibitionController@index')->name('exhibition.index');
    Route::get('/tambah_exhibition', 'ExhibitionController@tambah');
    Route::post('/exhibition_save', 'ExhibitionController@store');
    Route::get('/exhibition_getdata', 'ExhibitionController@datanya')->name('datatables.exhibition');
    Route::get('/exhibition_edit/{id}', 'ExhibitionController@edit')->name('exhibition.detail');
    Route::get('/exhibition_view/{id}', 'ExhibitionController@view')->name('exhibition.view');
    Route::get('/exhibition_delete/{id}', 'ExhibitionController@delete')->name('exhibition.delete');
    Route::post('/exhibition_update', 'ExhibitionController@update');
    Route::get('/carievent', 'ExhibitionController@loadP');

    //ADMIN
    Route::get('/exhibition_admin/{id}', 'ExhibitionController@indexadmin')->name('exhibition.indexadmin');
    Route::get('/exhibition_getdata_admin/{id}', 'ExhibitionController@datanyaadmin');

    //capacity utilization USER
    Route::get('/capulti', 'CapultiController@index')->name('capulti.index');
    Route::get('/tambah_capulti', 'CapultiController@tambah');
    Route::post('/capulti_save', 'CapultiController@store');
    Route::get('/capulti_getdata', 'CapultiController@datanya')->name('datatables.capulti');
    Route::get('/capulti_edit/{id}', 'CapultiController@edit')->name('capulti.detail');
    Route::get('/capulti_view/{id}', 'CapultiController@view')->name('capulti.view');
    Route::get('/capulti_delete/{id}', 'CapultiController@delete')->name('capulti.delete');
    Route::post('/capulti_update', 'CapultiController@update');

    //ADMIN
    Route::get('/capulti_admin/{id}', 'CapultiController@indexadmin')->name('capulti.indexadmin');
    Route::get('/capulti_getdata_admin/{id}', 'CapultiController@datanyaadmin');

    //raw material
    Route::get('/rawmaterial', 'RawmaterialController@index')->name('rawmaterial.index');
    Route::get('/tambah_rawmaterial', 'RawmaterialController@tambah');
    Route::post('/rawmaterial_save', 'RawmaterialController@store');
    Route::get('/rawmaterial_getdata', 'RawmaterialController@datanya')->name('datatables.rawmaterial');
    Route::get('/rawmaterial_edit/{id}', 'RawmaterialController@edit')->name('rawmaterial.detail');
    Route::get('/rawmaterial_view/{id}', 'RawmaterialController@view')->name('rawmaterial.view');
    Route::get('/rawmaterial_delete/{id}', 'RawmaterialController@delete')->name('rawmaterial.delete');
    Route::post('/rawmaterial_update', 'RawmaterialController@update');

    //ADMIN
    Route::get('/rawmaterial_admin/{id}', 'RawmaterialController@indexadmin');
    Route::get('/rawmaterial_getdata_admin/{id}', 'RawmaterialController@datanyaadmin');

    //labor
    Route::get('/labor', 'LaborController@index')->name('brand.index');
    Route::get('/tambah_labor', 'LaborController@tambah');
    Route::post('/labor_save', 'LaborController@store');
    Route::get('/labor_getdata', 'LaborController@datanya')->name('datatables.labor');
    Route::get('/labor_edit/{id}', 'LaborController@edit')->name('labor.detail');
    Route::get('/labor_view/{id}', 'LaborController@view')->name('labor.view');
    Route::get('/labor_delete/{id}', 'LaborController@delete')->name('labor.delete');
    Route::post('/labor_update', 'LaborController@update');

    //ADMIN
    Route::get('/labor_admin/{id}', 'LaborController@indexadmin');
    Route::get('/labor_getdata_admin/{id}', 'LaborController@datanyaadmin');

    //consultan
    Route::get('/consultan', 'ConsultanController@index')->name('consultan.index');
    Route::get('/tambah_consultan', 'ConsultanController@tambah');
    Route::post('/consultan_save', 'ConsultanController@store');
    Route::get('/consultan_getdata', 'ConsultanController@datanya')->name('datatables.consultan');
    Route::get('/consultan_edit/{id}', 'ConsultanController@edit')->name('consultan.detail');
    Route::get('/consultan_view/{id}', 'ConsultanController@view')->name('consultan.view');
    Route::get('/consultan_delete/{id}', 'ConsultanController@delete')->name('consultan.delete');
    Route::post('/consultan_update', 'ConsultanController@update');

    //ADMIN
    Route::get('/consultan_admin/{id}', 'ConsultanController@indexadmin');
    Route::get('/consultan_getdata_admin/{id}', 'ConsultanController@datanyaadmin');

    //training
    Route::get('/training', 'TrainingController@index')->name('training.index');
    Route::get('/tambah_training', 'TrainingController@tambah');
    Route::post('/training_save', 'TrainingController@store');
    Route::get('/training_getdata', 'TrainingController@datanya')->name('datatables.training');
    Route::get('/training_edit/{id}', 'TrainingController@edit')->name('training.detail');
    Route::get('/training_view/{id}', 'TrainingController@view')->name('training.vieweksportir');
    Route::get('/training_delete/{id}', 'TrainingController@delete')->name('training.delete');
    Route::post('/training_update', 'TrainingController@update');

    //ADMIN
    Route::get('/training_admin/{id}', 'TrainingController@indexadmin');
    Route::get('/training_getdata_admin/{id}', 'TrainingController@datanyaadmin');

    //tax
    Route::get('/taxes', 'TaxesController@index')->name('taxes.index');
    Route::get('/tambah_taxes', 'TaxesController@tambah');
    Route::post('/taxes_save', 'TaxesController@store');
    Route::get('/taxes_getdata', 'TaxesController@datanya')->name('datatables.taxes');
    Route::get('/taxes_edit/{id}', 'TaxesController@edit')->name('taxes.detail');
    Route::get('/taxes_view/{id}', 'TaxesController@view')->name('taxes.view');
    Route::get('/taxes_delete/{id}', 'TaxesController@delete')->name('taxes.delete');
    Route::post('/taxes_update', 'TaxesController@update');

    //ADMIN
    Route::get('/taxes_admin/{id}', 'TaxesController@indexadmin');
    Route::get('/taxes_getdata_admin/{id}', 'TaxesController@datanyaadmin');

    //Meidi
    //Product
    Route::get('/product_admin/{id}', 'EksProductController@index_admin')->name('eksproduct.index_admin');
    Route::get('/product', 'EksProductController@index')->name('eksproduct.index');
    Route::get('/product_getdata_admin/{id}', 'EksProductController@datanya_admin')->name('datatables.eksproduct_admin');
    Route::get('/product_getdata', 'EksProductController@datanya')->name('datatables.eksproduct');
    Route::get('/getsub/', 'EksProductController@getSub')->name('eksproduct.getSub');
    Route::get('/getHsCode/', 'EksProductController@getHsCode')->name('eksproduct.getHsCode');
    Route::get('/tambah_product', 'EksProductController@tambah');
    Route::post('/product_save', 'EksProductController@store');
    Route::get('/product_view/{id}', 'EksProductController@view')->name('eksproduct.view');
    Route::get('/product_edit/{id}', 'EksProductController@edit')->name('eksproduct.edit');
    Route::post('/product_update/{id}', 'EksProductController@update');
    Route::get('/product_delete/{id}', 'EksProductController@delete')->name('eksproduct.delete');
    Route::get('/verifikasi_product/{id}', 'EksProductController@verifikasi')->name('eksproduct.verifikasi');
    Route::post('/actver_product/{id}', 'EksProductController@verifikasi_act')->name('eksproduct.verifikasi_act');

    //Angga
    //Service
    Route::prefix('service')->group(function () {
        Route::name('service.')->group(function () {
            Route::get('/', 'ServiceController@index')->name('index');
            Route::get('/admin/{id}', 'ServiceController@index_admin')->name('index_admin');
		    Route::get('/getData/{id}', 'ServiceController@getData')->name('getData');
		    Route::get('/create/', 'ServiceController@create')->name('create');
		    Route::get('/edit/{id}', 'ServiceController@edit')->name('edit');
		    Route::get('/view/{id}', 'ServiceController@view')->name('view');
		    Route::post('/store/', 'ServiceController@store')->name('store');
		    Route::post('/update/{id}', 'ServiceController@update')->name('update');
		    Route::get('/destroy/{id}', 'ServiceController@destroy')->name('destroy');
    		Route::get('/verifikasi/{id}', 'ServiceController@verifikasi')->name('verifikasi');
    		Route::get('/approve/{id}', 'ServiceController@approval')->name('approve');
        });
    });
});

//////////////////////////////////////////ILYAS END////////////////////////////////////////////////////////////////////////////////

//Meidi
Route::namespace('Inquiry')->group(function () {
    //Eksportir
    Route::get('/inquiry', 'InquiryEksController@index')->name('eksportir.inquiry.index');
    Route::get('/inquiry/getData/{jenis}', 'InquiryEksController@getData')->name('eksportir.inquiry.getData');
    Route::get('/inquiry/joined/{id}', 'InquiryEksController@joined')->name('eksportir.inquiry.join');
    Route::get('/inquiry/accept_chat/{id}', 'InquiryEksController@accept_chat')->name('eksportir.inquiry.accept_chat');
    Route::get('/inquiry/view/{id}', 'InquiryEksController@view')->name('eksportir.inquiry.view');
    Route::get('/inquiry/chatting/{id}', 'InquiryEksController@chatting')->name('eksportir.inquiry.chatting');
    Route::get('/inquiry/sendChat', 'InquiryEksController@sendChat')->name('eksportir.inquiry.sendChat');
    Route::post('/inquiry/fileChat', 'InquiryEksController@fileChat')->name('eksportir.inquiry.fileChat');
    Route::get('/inquiry/dealing/{id}/{status}', 'InquiryEksController@dealing')->name('eksportir.inquiry.dealing');

    //Perwakilan
    Route::get('/inquiry_perwakilan', 'InquiryWakilController@index')->name('perwakilan.inquiry.index');
    Route::get('/inquiry_perwakilan/getData', 'InquiryWakilController@getData')->name('perwakilan.inquiry.getData');
    Route::get('/inquiry_perwakilan/create', 'InquiryWakilController@create')->name('perwakilan.inquiry.create');
    Route::post('/inquiry_perwakilan/store', 'InquiryWakilController@store')->name('perwakilan.inquiry.store');
    Route::get('/inquiry_perwakilan/edit/{id}', 'InquiryWakilController@edit')->name('perwakilan.inquiry.edit');
    Route::post('/inquiry_perwakilan/update/{id}', 'InquiryWakilController@update')->name('perwakilan.inquiry.update');
    Route::post('/inquiry_perwakilan/broadcasting', 'InquiryWakilController@broadcasting')->name('perwakilan.inquiry.broadcasting');
    Route::get('/inquiry_perwakilan/view/{id}', 'InquiryWakilController@view')->name('perwakilan.inquiry.view');
    Route::get('/inquiry_perwakilan/delete/{id}', 'InquiryWakilController@delete')->name('perwakilan.inquiry.delete');
    Route::get('/inquiry_perwakilan/getDataCompany/{id}', 'InquiryWakilController@getDataCompany')->name('perwakilan.inquiry.getDataCompany');
    Route::get('/inquiry_perwakilan/verifikasi/{id}', 'InquiryWakilController@verifikasi')->name('perwakilan.inquiry.verifikasi');
    Route::get('/inquiry_perwakilan/chatting/{id}', 'InquiryWakilController@chatting')->name('perwakilan.inquiry.chatting');
    Route::get('/inquiry_perwakilan/sendChat', 'InquiryWakilController@sendChat')->name('perwakilan.inquiry.sendChat');
    Route::post('/inquiry_perwakilan/fileChat', 'InquiryWakilController@fileChat')->name('perwakilan.inquiry.fileChat');
    Route::get('/inquiry_perwakilan/view_detail/{id}', 'InquiryWakilController@view_detail')->name('perwakilan.inquiry.view_detail');
    Route::get('/inquiry_perwakilan/delete_detail/{id}', 'InquiryWakilController@delete_detail')->name('perwakilan.inquiry.delete_detail');

    //Admin
    Route::get('/inquiry_admin', 'InquiryAdminController@index')->name('admin.inquiry.index');
    Route::get('/inquiry_admin/getDataAdmin', 'InquiryAdminController@getDataAdmin')->name('admin.inquiry.getDataAdmin');
    Route::get('/inquiry_admin/create', 'InquiryAdminController@create')->name('admin.inquiry.create');
    Route::post('/inquiry_admin/store', 'InquiryAdminController@store')->name('admin.inquiry.store');
    Route::get('/inquiry_admin/edit/{id}', 'InquiryAdminController@edit')->name('admin.inquiry.edit');
    Route::post('/inquiry_admin/update/{id}', 'InquiryAdminController@update')->name('admin.inquiry.update');
    Route::post('/inquiry_admin/broadcasting', 'InquiryAdminController@broadcasting')->name('admin.inquiry.broadcasting');
    Route::get('/inquiry_admin/view/{id}', 'InquiryAdminController@view')->name('admin.inquiry.view');
    Route::get('/inquiry_admin/delete/{id}', 'InquiryAdminController@delete')->name('admin.inquiry.delete');
    Route::get('/inquiry_admin/getDataCompany/{id}', 'InquiryAdminController@getDataCompany')->name('admin.inquiry.getDataCompany');
    Route::get('/inquiry_admin/verifikasi/{id}', 'InquiryAdminController@verifikasi')->name('admin.inquiry.verifikasi');
    Route::get('/inquiry_admin/chatting/{id}', 'InquiryAdminController@chatting')->name('admin.inquiry.chatting');
    Route::get('/inquiry_admin/sendChat', 'InquiryAdminController@sendChat')->name('admin.inquiry.sendChat');
    Route::post('/inquiry_admin/fileChat', 'InquiryAdminController@fileChat')->name('admin.inquiry.fileChat');
    Route::get('/inquiry_admin/view_detail/{id}', 'InquiryAdminController@view_detail')->name('admin.inquiry.view_detail');
    Route::get('/inquiry_admin/delete_detail/{id}', 'InquiryAdminController@delete_detail')->name('admin.inquiry.delete_detail');
    //Tab Perwakilan
    Route::get('/inquiry_admin/getPerwakilan', 'InquiryAdminController@getPerwakilan')->name('admin.inquiry.getPerwakilan');
    Route::get('/inquiry_admin/detail_perwakilan/{id}', 'InquiryAdminController@detail_perwakilan')->name('admin.inquiry.detail_perwakilan');
    Route::get('/inquiry_admin/getDataPerwakilan/{id}', 'InquiryAdminController@getDataPerwakilan')->name('admin.inquiry.getDataPerwakilan');
    Route::get('/inquiry_admin/perwakilan_view/{id}', 'InquiryAdminController@perwakilan_view')->name('admin.inquiry.perwakilan_view');
    Route::get('/inquiry_admin/getDataCompanyWakil/{id}', 'InquiryAdminController@getDataCompanyWakil')->name('admin.inquiry.getDataCompanyWakil');
    Route::get('/inquiry_admin/view_inquiry/{id}', 'InquiryAdminController@view_inquiry')->name('admin.inquiry.view_inquiry');
    //Tab Importir
    Route::get('/inquiry_admin/getDataImportir', 'InquiryAdminController@getDataImportir')->name('admin.inquiry.getDataImportir');
    Route::get('/inquiry_admin/view_importir/{id}', 'InquiryAdminController@view_importir')->name('admin.inquiry.view_importir');
});

//YOSS---------------------------------------------

//Ticketing Support
Route::namespace('TicketingSupport')->group(function () {
    //Admin
    Route::get('admin/ticketing', 'TicketingSupportControllerAdmin@index')->name('ticket_support.index.admin');
    Route::get('admin/ticketing/getData', 'TicketingSupportControllerAdmin@getData')->name('ticket_support.getData.admin');
    Route::get('admin/ticketing/chatview/{id}', 'TicketingSupportControllerAdmin@vchat')->name('ticket_support.vchat.admin');
    Route::get('admin/ticketing/view/{id}', 'TicketingSupportControllerAdmin@view')->name('ticket_support.view.admin');
    Route::post('admin/ticketing/sendchat', 'TicketingSupportControllerAdmin@sendchat')->name('ticket_support.sendchat.admin');
    Route::post('admin/ticketing/sendFilechat', 'TicketingSupportControllerAdmin@sendFilechat')->name('ticket_support.sendFilechat.admin');
    Route::get('admin/ticketing/delete/{id}', 'TicketingSupportControllerAdmin@destroy')->name('ticket_support.delete.admin');
    Route::post('admin/ticketing/change', 'TicketingSupportControllerAdmin@change')->name('ticket_support.delete.change');
});

//Training
Route::namespace('Training')->group(function () {
    //Admin
    Route::get('admin/training', 'TrainingControllerAdmin@index')->name('training.index.admin');
    Route::get('admin/training/getData', 'TrainingControllerAdmin@getData')->name('training.getData.admin');
    Route::get('admin/training/create', 'TrainingControllerAdmin@create')->name('training.create.admin');
    Route::post('admin/training/store', 'TrainingControllerAdmin@store')->name('training.store.admin');
    Route::post('admin/training/update/{id}', 'TrainingControllerAdmin@update')->name('training.update.admin');
    Route::get('admin/training/publish/{id}', 'TrainingControllerAdmin@publish')->name('training.publish.admin');
    Route::get('admin/training/edit/{id}', 'TrainingControllerAdmin@edit')->name('training.edit.admin');
    Route::get('admin/training/view/{id}', 'TrainingControllerAdmin@view')->name('training.view.admin');
    Route::get('admin/training/destroy/{id}', 'TrainingControllerAdmin@destroy')->name('training.destroy.admin');
    Route::get('admin/training/verifed/{id}/{id_tr}/{id_profil}', 'TrainingControllerAdmin@verifed')->name('training.verifed.admin');
    Route::get('/Training-getDataInterest/{id}', 'TrainingControllerAdmin@getDataInterest')->name('training.getDataInterest');
    //Eksportir
    Route::get('training', 'TrainingControllerEksportir@index')->name('training.index');
    Route::get('training/getData', 'TrainingControllerEksportir@getData')->name('training.getData');
    Route::get('training/view', 'TrainingControllerEksportir@view')->name('training.view');
    Route::post('training/join', 'TrainingControllerEksportir@join')->name('training.join');
    Route::get('training/search', 'TrainingControllerEksportir@search')->name('training.search');
});

//END YOSS ------------------------------------------

//start mindy
Route::post('/captchaValidate', 'CaptchaController@captchaValidate')->name('captcha');
Route::get('refreshcaptcha', 'CaptchaController@refreshCaptcha')->name('refreshcaptcha');
//end mindy