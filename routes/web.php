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
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::get('/', function () {
    return redirect('/login');
});
Route::get('switch/{locale}', function ($locale) {
    App::setLocale($locale);
});
Route::get('/registrasi_pembeli', 'RegistrasiController@registrasi_pembeli');
Route::get('/api-tracking/', 'Api\TrackingController@tracking')->name('api.tracking');

Route::namespace('FrontEnd')->group(function () {
	Route::get('/front_end', 'FrontController@index');
	Route::get('/front_end/all_product', 'FrontController@all_product');
	Route::get('/front_end/category_product/{id}', 'FrontController@product_category');
	Route::get('/front_end/product/{id}', 'FrontController@view_product');

	////////////////////////////////  AeNGeGeA  ///////////////////////////////////////////
	Route::get('/front_end/research-corner', 'FrontController@research_corner');
	Route::get('/front_end/tracking', 'FrontController@tracking');
	////////////////////////////////  AeNGeGeA  ///////////////////////////////////////////

	/**
	 * Createdby Intan Kamelia
	*/
	Route::get('/front_end/event', 'FrontController@Event');
	Route::any('/front_end/event/search', 'FrontController@search_event');
	Route::get('/front_end/join_event/{id}', 'FrontController@join_event');

  //YOSS
  //Front End TrainingController
  Route::get('/front_end/training', 'FrontController@indexTraining');
  Route::get('frontend/training/search', 'FrontController@indexTrainingSearch');
  //End Training Frontend


});

Route::get('/br_importir', 'BRFrontController@br_importir');
Route::get('/br_importir_add', 'BRFrontController@br_importir_add');
Route::get('/br_importir_detail/{id}', 'BRFrontController@br_importir_detail');
Route::get('/br_importir_lc/{id}', 'BRFrontController@br_importir_lc');
Route::get('/br_importir_bc/{id}', 'BRFrontController@br_importir_bc');
Route::post('/br_importir_save', 'BRFrontController@br_importir_save');
Route::get('/ambilbroad/{id}', 'BRFrontController@ambilbroad');
/* Route::get('/registrasi_pembeli/{locale}', function ($locale) {
    App::setLocale($locale);
    return view('auth.register_pembeli');
}); */
Route::post('/simpan_rpembeli', 'RegistrasiController@simpan_rpembeli');
Route::get('/verifypembeli/{id}','RegistrasiController@verifypembeli');

Route::get('/registrasi_penjual','RegistrasiController@registrasi_penjual');
Route::post('/simpan_rpenjual','RegistrasiController@simpan_rpenjual');
Route::get('/verifypenjual/{id}','RegistrasiController@verifypenjual');

Route::post('/loginei', 'LoginEIController@loginei')->name('loginei.login');




//////////////////////////////////// END FRONTEND ////////////////////////////////////////////////////////////
//////////////////////////////////// START BACKEND ////////////////////////////////////////////////////////////

Route::get('/login', 'HomeController@index');
//Verify User
Route::get('/verifyuser', 'VerifyuserController@index');
Route::get('/geteksportir', 'VerifyuserController@geteksportir');
Route::get('/verifyimportir', 'VerifyuserController@index2');
Route::get('/getimportir', 'VerifyuserController@getimportir');
Route::get('/profilperwakilan', 'VerifyuserController@index3');
Route::get('/getpw', 'VerifyuserController@getpw');
Route::get('/tambahperwakilan', 'VerifyuserController@tambahperwakilan');
Route::get('/detailverify/{id}', 'VerifyuserController@detailverify');
Route::get('/hapusperwakilan/{id}', 'VerifyuserController@hapusperwakilan');
Route::get('/saveverify/{id}', 'VerifyuserController@saveverify');
Route::get('/profil/{id}/{id2}', 'VerifyuserController@profil');
Route::get('/profil2/{id}/{id2}', 'VerifyuserController@profil2');
Route::post('/simpan_profil','VerifyuserController@simpan_profil');
Route::post('/simpan_profil2','VerifyuserController@simpan_profil2');
Route::post('/simpanperwakilan','VerifyuserController@simpanperwakilan');

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
Route::get('/getcsc', 'BuyingRequestController@getcsc');
Route::get('/br_add', 'BuyingRequestController@add');
Route::get('/ambilt2/{id}', 'BuyingRequestController@ambilt2');
Route::get('/ambilt3/{id}', 'BuyingRequestController@ambilt3');
Route::post('/br_save', 'BuyingRequestController@br_save');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/gantipass', 'HomeController@gantipass');
Route::post('/updatepass', 'HomeController@updatepass');

Route::namespace('Master')->group(function () {
// Angga Start
	//Master Country
	Route::get('master-country/', 'MasterCountryController@index')->name('master.country.index');
	Route::get('master-country/getData/', 'MasterCountryController@getData')->name('master.country.getData');
	Route::get('master-country/create/', 'MasterCountryController@create')->name('master.country.create');
	Route::get('master-country/check-kode/', 'MasterCountryController@check')->name('master.country.kode');
	Route::get('master-country/edit/{id}', 'MasterCountryController@edit')->name('master.country.edit');
	Route::get('master-country/view/{id}', 'MasterCountryController@view')->name('master.country.view');
	Route::post('master-country/store/{param}','MasterCountryController@store')->name('master.country.store');
	Route::get('master-country/destroy/{id}', 'MasterCountryController@destroy')->name('master.country.destroy');
	Route::get('master-country/export/', 'MasterCountryController@export')->name('master.country.export');
	//Master City
	Route::get('master-city/', 'MasterCityController@index')->name('master.city.index');
	Route::get('master-city/getData/', 'MasterCityController@getData')->name('master.city.getData');
	Route::get('master-city/create/', 'MasterCityController@create')->name('master.city.create');
	Route::get('master-city/edit/{id}', 'MasterCityController@edit')->name('master.city.edit');
	Route::get('master-city/view/{id}', 'MasterCityController@view')->name('master.city.view');
	Route::post('master-city/store/{param}','MasterCityController@store')->name('master.city.store');
	Route::get('master-city/destroy/{id}', 'MasterCityController@destroy')->name('master.city.destroy');
	Route::get('master-city/export/', 'MasterCityController@export')->name('master.city.export');
	//Master Province
	Route::get('master-province/', 'MasterProvinceController@index')->name('master.province.index');
	Route::get('master-province/getData/', 'MasterProvinceController@getData')->name('master.province.getData');
	Route::get('master-province/create/', 'MasterProvinceController@create')->name('master.province.create');
	Route::get('master-province/check-kode/', 'MasterProvinceController@check')->name('master.province.kode');
	Route::get('master-province/edit/{id}', 'MasterProvinceController@edit')->name('master.province.edit');
	Route::get('master-province/view/{id}', 'MasterProvinceController@view')->name('master.province.view');
	Route::post('master-province/store/{param}','MasterProvinceController@store')->name('master.province.store');
	Route::get('master-province/destroy/{id}', 'MasterProvinceController@destroy')->name('master.province.destroy');
	Route::get('master-province/export/', 'MasterProvinceController@export')->name('master.province.export');
	//Master Port
	Route::get('master-port/', 'MasterPortController@index')->name('master.port.index');
	Route::get('master-port/getData/', 'MasterPortController@getData')->name('master.port.getData');
	Route::get('master-port/create/', 'MasterPortController@create')->name('master.port.create');
	Route::get('master-port/check-kode/', 'MasterPortController@check')->name('master.port.kode');
	Route::get('master-port/edit/{id}', 'MasterPortController@edit')->name('master.port.edit');
	Route::get('master-port/view/{id}', 'MasterPortController@view')->name('master.port.view');
	Route::post('master-port/store/{param}','MasterPortController@store')->name('master.port.store');
	Route::get('master-port/destroy/{id}', 'MasterPortController@destroy')->name('master.port.destroy');
	Route::get('master-port/export/', 'MasterPortController@export')->name('master.port.export');
// Angga End
});

Route::namespace('Management')->group(function () {
// Angga Start
	//Management Category Product
	Route::get('management-category-product/', 'CategoryProductController@index')->name('management.category-product.index');
	Route::get('management-category-product/getData/', 'CategoryProductController@getData')->name('management.category-product.getData');
	Route::get('management-category-product/create/', 'CategoryProductController@create')->name('management.category-product.create');
	Route::get('management-category-product/edit/{id}', 'CategoryProductController@edit')->name('management.category-product.edit');
	Route::get('management-category-product/view/{id}', 'CategoryProductController@view')->name('management.category-product.view');
	Route::get('management-category-product/level_2/', 'CategoryProductController@level_2')->name('management.category-product.level2');
	Route::post('management-category-product/store/{param}','CategoryProductController@store')->name('management.category-product.store');
	Route::get('management-category-product/destroy/{id}', 'CategoryProductController@destroy')->name('management.category-product.destroy');
	//Management Data Contact Us
	Route::get('management-contact-us/', 'DataContactUsController@index')->name('management.contactus.index');
	Route::get('management-contact-us/getData/', 'DataContactUsController@getData')->name('management.contactus.getData');
	Route::get('management-contact-us/view/{id}', 'DataContactUsController@view')->name('management.contactus.view');
	Route::get('management-contact-us/create/', 'DataContactUsController@create')->name('management.contactus.create');
	Route::get('management-contact-us/destroy/{id}', 'DataContactUsController@destroy')->name('management.contactus.destroy');
	Route::post('contact-us/send/','DataContactUsController@store')->name('management.contactus.store');
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

		Route::post('/getEventOrg', 'EventController@getEventOrg');
		Route::post('/getEventPlace', 'EventController@getEventPlace');

});


/////////////////////////////////////////ILYAS START//////////////////////////////////////////////////////////////////////////////////
Route::namespace('Eksportir')->prefix('eksportir')->group(function () {

    //Annual SALES
    Route::get('/annual_sales', 'AnnualController@index')->name('annual_sales.index');
    Route::get('/tambah_annual', 'AnnualController@tambah');
    Route::post('/annual_save', 'AnnualController@store');
    Route::get('/sales_getdata', 'AnnualController@datanya')->name('datatables.sales');
    Route::get('/sales_edit/{id}', 'AnnualController@edit')->name('sales.detail');
    Route::get('/sales_view/{id}', 'AnnualController@view')->name('sales.view');
    Route::get('/sales_delete/{id}', 'AnnualController@delete')->name('sales.delete');
    Route::post('/sales_update', 'AnnualController@update');

    //Brand
    Route::get('/brand', 'BrandController@index')->name('brand.index');
    Route::get('/tambah_brand', 'BrandController@tambah');
    Route::post('/brand_save', 'BrandController@store');
    Route::get('/brand_getdata', 'BrandController@datanya')->name('datatables.brand');
    Route::get('/brand_edit/{id}', 'BrandController@edit')->name('brand.detail');
    Route::get('/brand_view/{id}', 'BrandController@view')->name('brand.view');
    Route::get('/brand_delete/{id}', 'BrandController@delete')->name('brand.delete');
    Route::post('/brand_update', 'BrandController@update');

    //country patern brand
    Route::get('/country_patern_brand', 'CountryPaternBrandController@index')->name('country_patern_brand.index');
    Route::get('/tambah_country_patern_brand', 'CountryPaternBrandController@tambah');
    Route::post('/country_patern_brand_save', 'CountryPaternBrandController@store');
    Route::get('/country_patern_brand_getdata', 'CountryPaternBrandController@datanya')->name('datatables.country_patern_brand');
    Route::get('/country_patern_brand_edit/{id}', 'CountryPaternBrandController@edit')->name('country_patern_brand.detail');
    Route::get('/country_patern_brand_view/{id}', 'CountryPaternBrandController@view')->name('country_patern_brand.view');
    Route::get('/country_patern_brand_delete/{id}', 'CountryPaternBrandController@delete')->name('country_patern_brand.delete');
    Route::post('/country_patern_brand_update', 'CountryPaternBrandController@update');

    //production capacity
    Route::get('/product_capacity', 'ProcapController@index')->name('brand.index');
    Route::get('/tambah_procap', 'ProcapController@tambah');
    Route::post('/procap_save', 'ProcapController@store');
    Route::get('/procap_getdata', 'ProcapController@datanya')->name('datatables.procap');
    Route::get('/procap_edit/{id}', 'ProcapController@edit')->name('procap.detail');
    Route::get('/procap_view/{id}', 'ProcapController@view')->name('procap.view');
    Route::get('/procap_delete/{id}', 'ProcapController@delete')->name('procap.delete');
    Route::post('/procap_update', 'ProcapController@update');

    //contact
    Route::get('/contact', 'ContactController@index')->name('contact.index');
    Route::get('/tambah_contact', 'ContactController@tambah');
    Route::post('/contact_save', 'ContactController@store');
    Route::get('/contact_getdata', 'ContactController@datanya')->name('datatables.contact');
    Route::get('/contact_edit/{id}', 'ContactController@edit')->name('contact.detail');
    Route::get('/contact_view/{id}', 'ContactController@view')->name('contact.view');
    Route::get('/contact_delete/{id}', 'ContactController@delete')->name('contact.delete');
    Route::post('/contact_update', 'ContactController@update');

    //export destination
    Route::get('/export_destination', 'ExsdesController@index')->name('exportdes.index');
    Route::get('/tambah_export_destination', 'ExsdesController@tambah');
    Route::post('/exdes_save', 'ExsdesController@store');
    Route::get('/exdes_getdata', 'ExsdesController@datanya')->name('datatables.exdes');
    Route::get('/exdes_edit/{id}', 'ExsdesController@edit')->name('exdes.detail');
    Route::get('/exdes_view/{id}', 'ExsdesController@view')->name('exdes.view');
    Route::get('/exdes_delete/{id}', 'ExsdesController@delete')->name('exdes.delete');
    Route::post('/exdes_update', 'ExsdesController@update');

    //port landing
    Route::get('/portland', 'PortlandController@index')->name('portland.index');
    Route::get('/tambah_portland', 'PortlandController@tambah');
    Route::post('/portland_save', 'PortlandController@store');
    Route::get('/portland_getdata', 'PortlandController@datanya')->name('datatables.portland');
    Route::get('/portland_edit/{id}', 'PortlandController@edit')->name('portland.detail');
    Route::get('/portland_view/{id}', 'PortlandController@view')->name('portland.view');
    Route::get('/portland_delete/{id}', 'PortlandController@delete')->name('portland.delete');
    Route::post('/portland_update', 'PortlandController@update');

    //exhibition
    Route::get('/exhibition', 'ExhibitionController@index')->name('exhibition.index');
    Route::get('/tambah_exhibition', 'ExhibitionController@tambah');
//    Route::post('/brand_save', 'BrandController@store');
//    Route::get('/brand_getdata', 'BrandController@datanya')->name('datatables.brand');
//    Route::get('/brand_edit/{id}', 'BrandController@edit')->name('brand.detail');
//    Route::get('/brand_view/{id}', 'BrandController@view')->name('brand.view');
//    Route::get('/brand_delete/{id}', 'BrandController@delete')->name('brand.delete');
//    Route::post('/brand_update', 'BrandController@update');

    //capacity utilization
    Route::get('/capulti', 'CapultiController@index')->name('capulti.index');
    Route::get('/tambah_capulti', 'CapultiController@tambah');
    Route::post('/capulti_save', 'CapultiController@store');
    Route::get('/capulti_getdata', 'CapultiController@datanya')->name('datatables.capulti');
    Route::get('/capulti_edit/{id}', 'CapultiController@edit')->name('capulti.detail');
    Route::get('/capulti_view/{id}', 'CapultiController@view')->name('capulti.view');
    Route::get('/capulti_delete/{id}', 'CapultiController@delete')->name('capulti.delete');
    Route::post('/capulti_update', 'CapultiController@update');

    //raw material
    Route::get('/rawmaterial', 'RawmaterialController@index')->name('rawmaterial.index');
    Route::get('/tambah_rawmaterial', 'RawmaterialController@tambah');
    Route::post('/rawmaterial_save', 'RawmaterialController@store');
    Route::get('/rawmaterial_getdata', 'RawmaterialController@datanya')->name('datatables.rawmaterial');
    Route::get('/rawmaterial_edit/{id}', 'RawmaterialController@edit')->name('rawmaterial.detail');
    Route::get('/rawmaterial_view/{id}', 'RawmaterialController@view')->name('rawmaterial.view');
    Route::get('/rawmaterial_delete/{id}', 'RawmaterialController@delete')->name('rawmaterial.delete');
    Route::post('/rawmaterial_update', 'RawmaterialController@update');

    //labor
    Route::get('/labor', 'LaborController@index')->name('brand.index');
    Route::get('/tambah_labor', 'LaborController@tambah');
    Route::post('/labor_save', 'LaborController@store');
    Route::get('/labor_getdata', 'LaborController@datanya')->name('datatables.labor');
    Route::get('/labor_edit/{id}', 'LaborController@edit')->name('labor.detail');
    Route::get('/labor_view/{id}', 'LaborController@view')->name('labor.view');
    Route::get('/labor_delete/{id}', 'LaborController@delete')->name('labor.delete');
    Route::post('/labor_update', 'LaborController@update');

    //consultan
//    Route::get('/brand', 'BrandController@index')->name('brand.index');
//    Route::get('/tambah_brand', 'BrandController@tambah');
//    Route::post('/brand_save', 'BrandController@store');
//    Route::get('/brand_getdata', 'BrandController@datanya')->name('datatables.brand');
//    Route::get('/brand_edit/{id}', 'BrandController@edit')->name('brand.detail');
//    Route::get('/brand_view/{id}', 'BrandController@view')->name('brand.view');
//    Route::get('/brand_delete/{id}', 'BrandController@delete')->name('brand.delete');
//    Route::post('/brand_update', 'BrandController@update');

    //training
    Route::get('/training', 'TrainingController@index')->name('training.index');
    Route::get('/tambah_training', 'TrainingController@tambah');
    Route::post('/training_save', 'TrainingController@store');
//    Route::get('/brand_getdata', 'BrandController@datanya')->name('datatables.brand');
//    Route::get('/brand_edit/{id}', 'BrandController@edit')->name('brand.detail');
//    Route::get('/brand_view/{id}', 'BrandController@view')->name('brand.view');
//    Route::get('/brand_delete/{id}', 'BrandController@delete')->name('brand.delete');
//    Route::post('/brand_update', 'BrandController@update');

    //tax
//    Route::get('/brand', 'BrandController@index')->name('brand.index');
//    Route::get('/tambah_brand', 'BrandController@tambah');
//    Route::post('/brand_save', 'BrandController@store');
//    Route::get('/brand_getdata', 'BrandController@datanya')->name('datatables.brand');
//    Route::get('/brand_edit/{id}', 'BrandController@edit')->name('brand.detail');
//    Route::get('/brand_view/{id}', 'BrandController@view')->name('brand.view');
//    Route::get('/brand_delete/{id}', 'BrandController@delete')->name('brand.delete');
//    Route::post('/brand_update', 'BrandController@update');

    //Meidi
    //Product
    Route::get('/product', 'EksProductController@index')->name('eksproduct.index');
    Route::get('/product_getdata', 'EksProductController@datanya')->name('datatables.eksproduct');
    Route::get('/getsub/', 'EksProductController@getSub')->name('eksproduct.getSub');
    Route::get('/tambah_product', 'EksProductController@tambah');
    Route::post('/product_save', 'EksProductController@store');
    Route::get('/product_view/{id}', 'EksProductController@view')->name('eksproduct.view');
    Route::get('/product_edit/{id}', 'EksProductController@edit')->name('eksproduct.edit');
    Route::post('/product_update/{id}', 'EksProductController@update');
    Route::get('/product_delete/{id}', 'EksProductController@delete')->name('eksproduct.delete');
    Route::get('/verifikasi_product/{id}', 'EksProductController@verifikasi')->name('eksproduct.verifikasi');
    Route::post('/actver_product/{id}', 'EksProductController@verifikasi_act')->name('eksproduct.verifikasi_act');
});

//////////////////////////////////////////ILYAS END////////////////////////////////////////////////////////////////////////////////

//YOSS---------------------------------------------

//Ticketing Support
Route::namespace('TicketingSupport')->group(function () {
  //Eksportir
  Route::get('/ticketing', 'TicketingSupportController@index')->name('ticket_support.index');
  Route::get('/ticketing/create', 'TicketingSupportController@create')->name('ticket_support.create');
  Route::get('/ticketing/getData', 'TicketingSupportController@getData')->name('ticket_support.getData');
  Route::post('/ticketing/store', 'TicketingSupportController@store')->name('ticket_support.store');
  Route::get('/ticketing/chatview/{id}', 'TicketingSupportController@vchat')->name('ticket_support.vchat');
  Route::post('/ticketing/sendchat', 'TicketingSupportController@sendchat')->name('ticket_support.sendchat');
  Route::get('ticketing/view/{id}', 'TicketingSupportController@view')->name('ticket_support.view');
  Route::get('ticketing/delete/{id}', 'TicketingSupportController@destroy')->name('ticket_support.delete');
  //Admin
  Route::get('admin/ticketing', 'TicketingSupportControllerAdmin@index')->name('ticket_support.index.admin');
  Route::get('admin/ticketing/getData', 'TicketingSupportControllerAdmin@getData')->name('ticket_support.getData.admin');
  Route::get('admin/ticketing/chatview/{id}', 'TicketingSupportControllerAdmin@vchat')->name('ticket_support.vchat.admin');
  Route::get('admin/ticketing/view/{id}', 'TicketingSupportControllerAdmin@view')->name('ticket_support.view.admin');
  Route::post('admin/ticketing/sendchat', 'TicketingSupportControllerAdmin@sendchat')->name('ticket_support.sendchat.admin');
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
  //Eksportir
  Route::get('training', 'TrainingControllerEksportir@index')->name('training.index');
  Route::get('training/getData', 'TrainingControllerEksportir@getData')->name('training.getData');
  Route::get('training/view', 'TrainingControllerEksportir@view')->name('training.view');
  Route::post('training/join', 'TrainingControllerEksportir@join')->name('training.join');
  Route::get('training/search', 'TrainingControllerEksportir@search')->name('training.search');
});

//END YOSS ------------------------------------------
