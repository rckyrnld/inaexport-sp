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


//pendaftaran
Route::get('publishsc', 'Pendaftaran\Pendaftaran_scController@publishsc');
Route::get('/cari_bl/{id}','Pendaftaran\Pendaftaran_scController@cari_bl');
Route::post('/simpanpub','Pendaftaran\Pendaftaran_scController@simpanpub');

Route::resource('pendaftaran_sc', 'Pendaftaran\Pendaftaran_scController');
Route::get('/pendaftaran_add','Pendaftaran\Pendaftaran_scController@create');
Route::post('/pendaftaran_insert','Pendaftaran\Pendaftaran_scController@store');
Route::post('/simpanaja','Pendaftaran\Pendaftaran_scController@simpanaja');
Route::get('/pendaftaran_edit/{id}','Pendaftaran\Pendaftaran_scController@edit');
Route::post('/pendaftaran_update/{id}','Pendaftaran\Pendaftaran_scController@update');
Route::get('/hapusp/{id}/{idb}','Pendaftaran\Pendaftaran_scController@hapusp');
Route::get('/pendaftaran_delete/{id}','Pendaftaran\Pendaftaran_scController@destroy');
Route::get('/pendaftaran_berkas/{id}','Pendaftaran\Pendaftaran_scController@upload_berkas');
Route::post('/uploadberkas/{id}','Pendaftaran\Pendaftaran_scController@simpanupload');
Route::get('/verifikasi_publish/{id}','Pendaftaran\Pendaftaran_scController@verifikasi_publish');
Route::get('/detail_publish/{id}','Pendaftaran\Pendaftaran_scController@detail_publish');
Route::get('/updatepublish/{id}','Pendaftaran\Pendaftaran_scController@updatepublish');
Route::get('/verifikasi_berkas/{id}','Pendaftaran\Pendaftaran_scController@verifikasi_berkas');
Route::get('/verifikasi_berkas_sesuai/{id}/{idsc}','Pendaftaran\Pendaftaran_scController@verifikasi_berkas_sesuai');
Route::post('/simpantamu','Pendaftaran\Pendaftaran_scController@simpantamu');
Route::get('/verifikasi_sc/{id}','Pendaftaran\Pendaftaran_scController@verifikasi_sc');

//urikes
Route::resource('urikes', 'UrikesController');
Route::post('/cari_urikes','UrikesController@search');
//rekaptamu
Route::resource('rekaptamu', 'RekapTamuController');
Route::get('/cari_tamu/{dari}/{sampai}','RekapTamuController@search');
Route::get('/cari_nama/{id}','RekapTamuController@searchn');
Route::get('/cari_nama2/{id}','RekapTamuController@searchn');
Route::get('/cari_detail/{f}/{dari}/{sampai}','RekapTamuController@searchd');
Route::resource('rekapsenjata', 'RekapSenjataController');
Route::resource('rekapamunisi', 'RekapAmunisiController');
Route::resource('pelaporansenjata', 'PelaporanSenjataController');
Route::get('/riwayatpelaporansenjata','PelaporanSenjataController@riwayatpelaporansenjata');
Route::post('/simpanpelaporan','PelaporanSenjataController@simpanpelaporan');
Route::get('/detailriwayatpelaporan/{id}','PelaporanSenjataController@detailriwayatpelaporan');
Route::get('/excelsenjata/{id}','PelaporanSenjataController@excelsenjata');
Route::resource('pelaporanamunisi', 'PelaporanAmunisiController');
Route::post('/simpanpelaporanamunisi','PelaporanAmunisiController@simpanpelaporanamunisi');
Route::get('/riwayatpelaporanamunisi','PelaporanAmunisiController@riwayatpelaporanamunisi');
Route::get('/detailriwayatpelaporanamunisi/{id}','PelaporanAmunisiController@detailriwayatpelaporanamunisi');
Route::get('/excelamunisi/{id}','PelaporanAmunisiController@excelamunisi');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/gantipass', 'HomeController@gantipass');
Route::post('/updatepass','HomeController@updatepass');

//webcame

Route::get('/webcame','Pendaftaran\Pendaftaran_scController@webcame');
Route::post('/simpanfoto','Pendaftaran\Pendaftaran_scController@simpanfoto');



// kerjasama
Route::resource('/kerjasama','KerjasamaController');
Route::post('tambahkerjasama','KerjasamaController@addKerjasama');
//Ubah kerjasama
Route::get('tambahkerjasama/{id}','KerjasamaController@ubahKerjasama');
Route::post('tambahkerjasama/{id}','KerjasamaController@simpanKerjasama');
Route::delete('tambahkerjasama/{id}','KerjasamaController@delete_kerjasama');

//satker
Route::resource('/kaliber','KaliberController');
Route::post('simpankaliber','KaliberController@simpankaliber');
Route::get('hapuskaliber/{id}','KaliberController@hapuskaliber');

Route::resource('/satker','SatkerController');
Route::post('simpansatker','SatkerController@simpansatker'); 
Route::get('hapussatker/{id}','SatkerController@hapussatker');

Route::resource('/loguser','LoguserController');
// senjata
Route::resource('/senjata','SenjataController');
Route::post('tambahsenjata','SenjataController@addSenjata');
Route::post('simpansenjata','SenjataController@simpangun');
Route::post('updatesenjata','SenjataController@updatesenjata');
//Ubah senjata
Route::get('editsenjata/{id}','SenjataController@editSenjata');
Route::get('tambahsenjata/{id}','SenjataController@ubahSenjata');
Route::get('ambilsubsenjata/{id}/{id2}','SenjataController@ambilsubsenjata');
Route::post('tambahsenjata/{id}','SenjataController@simpanSenjata');
Route::delete('tambahsenjata/{id}','SenjataController@delete_Senjata');

Route::resource('/amunisi','AmunisiController');
Route::post('simpanamunisi','AmunisiController@simpanamunisi');
Route::get('hapusamunisi/{id}','AmunisiController@hapusamunisi');
Route::get('editamunisi/{id}','AmunisiController@editamunisi');
Route::post('updateamunisi','AmunisiController@updateamunisi');
Route::get('putamunisi','AmunisiController@putamunisi');
Route::post('simpanput','AmunisiController@simpanput');
Route::get('pusamunisi','AmunisiController@pusamunisi');
Route::post('simpanpus','AmunisiController@simpanpus');

//kategori senjata
Route::resource('/kategori_senjata','KategoriSenjataController');
Route::post('tambahkategori_senjata','KategoriSenjataController@addKategoriSenjata');
//Ubah senjata
Route::get('tambahkategori_senjata/{id}','KategoriSenjataController@ubahKategoriSenjata');
Route::post('tambahkategori_senjata/{id}','KategoriSenjataController@simpanKategoriSenjata');
Route::delete('tambahkategori_senjata/{id}','KategoriSenjataController@delete_KategoriSenjata');



// Lemari
Route::resource('/lemari','LemariController');
Route::post('tambahlemari','LemariController@addLemari');
//Ubah Lemari
Route::get('tambahlemari/{id}','LemariController@ubahLemari');
Route::post('tambahlemari/{id}','LemariController@simpanLemari');
Route::delete('tambahlemari/{id}','LemariController@delete_Lemari');

// Lokasi
Route::resource('/lokasi','LokasiController');
Route::post('tambahlokasi','LokasiController@addLokasi');
//Ubah Lokasi
Route::get('tambahlokasi/{id}','LokasiController@ubahLokasi');
Route::post('tambahlokasi/{id}','LokasiController@simpanLokasi');
Route::delete('tambahlokasi/{id}','LokasiController@delete_Lokasi');


// Lokasi
Route::resource('/peminjamaansenjata','PeminjamanSenjataController');
Route::get('ambilaja/{id}','PeminjamanSenjataController@ambilaja');
Route::get('ambilaja2/{id}/{id2}/{id3}/{id4}/{id5}/{id6}','PeminjamanSenjataController@ambilaja2');
Route::get('/peminjaman_add','PeminjamanSenjataController@create');
Route::post('/peminjaman_insert','PeminjamanSenjataController@store');
Route::get('getsenjata/{id}', 'PeminjamanSenjataController@getsenjata');
Route::get('getamunisi/{id}', 'PeminjamanSenjataController@getamunisi');
Route::get('getalot/{id}', 'PeminjamanSenjataController@getalot');
Route::get('peminjamandetail/{id}', 'PeminjamanSenjataController@peminjamandetail');
Route::get('riwayatdetail/{id}', 'PeminjamanSenjataController@riwayatdetail');
Route::get('kembalikan/{idpinjam}', 'PeminjamanSenjataController@kembalikan');
Route::get('/pengembaliansenjata','PeminjamanSenjataController@pengembaliansenjata');
Route::get('/riwayatpeminjaman','PeminjamanSenjataController@riwayatpeminjaman');
Route::post('/kembalisenjata','PeminjamanSenjataController@kembalisenjata');

// Lokasi
Route::resource('/tamu','TamuController');
Route::get('gettam/{id}', 'TamuController@gettam');