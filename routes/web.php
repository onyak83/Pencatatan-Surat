<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [App\Http\Controllers\AuthController::class, 'viewLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

Route::group(['middleware' => ['auth', 'role:1,2']], function () {
    // surat masuk
    Route::get('/suratmasuk', [App\Http\Controllers\DashboardController::class, 'indexSuratMasuk'])->name('index.SuratMasuk');
    Route::get('/getsuratmasuk', [App\Http\Controllers\DashboardController::class, 'getSuratMasuk'])->name('get.SuratMasuk');
    Route::get('/createsuratmasuk', [App\Http\Controllers\DashboardController::class, 'createSuratMasuk'])->name('create.SuratMasuk');
    Route::post('/storesuratmasuk', [App\Http\Controllers\DashboardController::class, 'storeSuratMasuk'])->name('store.SuratMasuk');
    Route::get('/editsuratmasuk/{id}', [App\Http\Controllers\DashboardController::class, 'editSuratMasuk'])->name('edit.SuratMasuk');
    Route::put('/updatesuratmasuk/{id}', [App\Http\Controllers\DashboardController::class, 'updateSuratMasuk'])->name('update.SuratMasuk');
    Route::delete('/deletesuratmasuk/{id}', [App\Http\Controllers\DashboardController::class, 'deleteSuratMasuk'])->name('delete.SuratMasuk');
    Route::get('/preview/{id}/suratmasuk', [App\Http\Controllers\DashboardController::class, 'previewSuratMasuk'])->name('surat-masuk.preview');

    // disposisi
    Route::get('/disposisism', [App\Http\Controllers\DashboardController::class, 'indexDisposisiSuratMasuk'])->name('index.DisposisiSuratMasuk');
    Route::get('/getdisposisism', [App\Http\Controllers\DashboardController::class, 'getDisposisiSuratMasuk'])->name('get.DisposisiSuratMasuk');
    Route::get('/createdisposisism/{id}', [App\Http\Controllers\DashboardController::class, 'createDisposisiSuratMasuk'])->name('create.DisposisiSuratMasuk');
    Route::post('/storedisposisism', [App\Http\Controllers\DashboardController::class, 'storeDisposisiSuratMasuk'])->name('store.DisposisiSuratMasuk');
    Route::get('/editdisposisism/{id}', [App\Http\Controllers\DashboardController::class, 'editDisposisiSuratMasuk'])->name('edit.DisposisiSuratMasuk');
    Route::put('/updatedisposisism/{id}', [App\Http\Controllers\DashboardController::class, 'updateDisposisiSuratMasuk'])->name('update.DisposisiSuratMasuk');
    Route::delete('/deletedisposisism/{id}', [App\Http\Controllers\DashboardController::class, 'deleteDisposisiSuratMasuk'])->name('delete.DisposisiSuratMasuk');

    Route::get('/detailsmDisposisi/{id}', [App\Http\Controllers\DashboardController::class, 'detailsmDisposisi'])->name('detail.smDisposisi');

    // agenda surat masuk
    Route::get('/agendasuratmasuk', [App\Http\Controllers\DashboardController::class, 'indexAgendaSuratMasuk'])->name('index.AgendaSuratMasuk');
    Route::get('/getagendasuratmasuk', [App\Http\Controllers\DashboardController::class, 'getAgendaSuratMasuk'])->name('get.AgendaSuratMasuk');
    Route::post('/downloadagendasuratmasuk', [App\Http\Controllers\DashboardController::class, 'downloadAgendaSuratMasuk'])->name('download.AgendaSuratMasuk');

    // surat keluar
    Route::get('/suratkeluar', [App\Http\Controllers\DashboardController::class, 'indexSuratKeluar'])->name('index.SuratKeluar');
    Route::get('/getsuratkeluar', [App\Http\Controllers\DashboardController::class, 'getSuratKeluar'])->name('get.SuratKeluar');
    Route::get('/createsuratkeluar', [App\Http\Controllers\DashboardController::class, 'createSuratKeluar'])->name('create.SuratKeluar');
    Route::post('/storesuratkeluar', [App\Http\Controllers\DashboardController::class, 'storeSuratKeluar'])->name('store.SuratKeluar');
    Route::get('/editsuratkeluar/{id}', [App\Http\Controllers\DashboardController::class, 'editSuratKeluar'])->name('edit.SuratKeluar');
    Route::put('/updatesuratkeluar/{id}', [App\Http\Controllers\DashboardController::class, 'updateSuratKeluar'])->name('update.SuratKeluar');
    Route::delete('/deletesuratkeluar/{id}', [App\Http\Controllers\DashboardController::class, 'deleteSuratKeluar'])->name('delete.SuratKeluar');
    Route::get('/preview/{id}/suratkeluar', [App\Http\Controllers\DashboardController::class, 'previewSuratKeluar'])->name('surat-keluar.preview');

    Route::get('/ekspedisisuratkeluar', [App\Http\Controllers\DashboardController::class, 'indexEkspedisiSuratKeluar'])->name('index.EkspedisiSuratKeluar');
    Route::get('/getekspedisisuratkeluar', [App\Http\Controllers\DashboardController::class, 'getEkspedisiSuratKeluar'])->name('get.EkspedisiSuratKeluar');
    Route::post('/downloadekspedisisuratkeluar', [App\Http\Controllers\DashboardController::class, 'downloadEkspedisiSuratKeluar'])->name('download.EkspedisiSuratKeluar');

    // reload dropdown
    Route::get('/getInstansiDropdown', [App\Http\Controllers\DashboardController::class,'getInstansiDropdown'])->name('get.InstansiDropdown');

    // view arsip digital
    Route::get('/arsipdigital', [App\Http\Controllers\DashboardController::class, 'indexArsipDigital'])->name('index.ArsipDigital');
    Route::get('/getarsipdigital', [App\Http\Controllers\DashboardController::class, 'getArsipDigital'])->name('get.ArsipDigital');
    Route::get('/arsip-digital/detail/{id}', [App\Http\Controllers\DashboardController::class, 'detailArsipDigital'])->name('detail.ArsipDigital');

    //manajemen->user
    Route::get('/indexUser', [App\Http\Controllers\ManajemenController::class, 'indexUser'])->name('index.User');
    Route::get('/getUser', [App\Http\Controllers\ManajemenController::class, 'getUser'])->name('get.User');
    Route::get('/createUser', [App\Http\Controllers\ManajemenController::class, 'createUser'])->name('create.User');
    Route::post('/storeUser', [App\Http\Controllers\ManajemenController::class, 'storeUser'])->name('store.User');
    Route::get('/editUser/{id}', [App\Http\Controllers\ManajemenController::class, 'editUser'])->name('edit.User');
    Route::put('/updateUser/{id}', [App\Http\Controllers\ManajemenController::class, 'updateUser'])->name('update.User');
    Route::delete('/deleteUser/{id}', [App\Http\Controllers\ManajemenController::class, 'deleteUser'])->name('delete.User');

    //manajemen->pegawai
    Route::get('/indexPegawai', [App\Http\Controllers\ManajemenController::class, 'indexPegawai'])->name('index.Pegawai');
    Route::get('/getPegawai', [App\Http\Controllers\ManajemenController::class, 'getPegawai'])->name('get.Pegawai');
    Route::get('/createPegawai', [App\Http\Controllers\ManajemenController::class, 'createPegawai'])->name('create.Pegawai');
    Route::post('/storePegawai', [App\Http\Controllers\ManajemenController::class, 'storePegawai'])->name('store.Pegawai');
    Route::get('/editPegawai/{id}', [App\Http\Controllers\ManajemenController::class, 'editPegawai'])->name('edit.Pegawai');
    Route::put('/updatePegawai/{id}', [App\Http\Controllers\ManajemenController::class, 'updatePegawai'])->name('update.Pegawai');
    Route::delete('/deletePegawai/{id}', [App\Http\Controllers\ManajemenController::class, 'deletePegawai'])->name('delete.Pegawai');

    //manajemen->pangkat - gol
    Route::get('/indexPangkat', [App\Http\Controllers\ManajemenController::class, 'indexPangkat'])->name('index.Pangkat');
    Route::get('/getPangkat', [App\Http\Controllers\ManajemenController::class, 'getPangkat'])->name('get.Pangkat');
    Route::get('/createPangkat', [App\Http\Controllers\ManajemenController::class, 'createPangkat'])->name('create.Pangkat');
    Route::post('/storePangkat', [App\Http\Controllers\ManajemenController::class, 'storePangkat'])->name('store.Pangkat');
    Route::get('/editPangkat/{id}', [App\Http\Controllers\ManajemenController::class, 'editPangkat'])->name('edit.Pangkat');
    Route::put('/updatePangkat/{id}', [App\Http\Controllers\ManajemenController::class, 'updatePangkat'])->name('update.Pangkat');
    Route::delete('/deletePangkat/{id}', [App\Http\Controllers\ManajemenController::class, 'deletePangkat'])->name('delete.Pangkat');


    //manajemen->sifat surat
    Route::get('/indexSifatSurat', [App\Http\Controllers\ManajemenController::class, 'indexSifatSurat'])->name('index.SifatSurat');
    Route::get('/getSifatSurat', [App\Http\Controllers\ManajemenController::class, 'getSifatSurat'])->name('get.SifatSurat');
    Route::get('/createSifatSurat', [App\Http\Controllers\ManajemenController::class, 'createSifatSurat'])->name('create.SifatSurat');
    Route::post('/storeSifatSurat', [App\Http\Controllers\ManajemenController::class, 'storeSifatSurat'])->name('store.SifatSurat');
    Route::get('/editSifatSurat/{id}', [App\Http\Controllers\ManajemenController::class, 'editSifatSurat'])->name('edit.SifatSurat');
    Route::put('/updateSifatSurat/{id}', [App\Http\Controllers\ManajemenController::class, 'updateSifatSurat'])->name('update.SifatSurat');
    Route::delete('/deleteSifatSurat/{id}', [App\Http\Controllers\ManajemenController::class, 'deleteSifatSurat'])->name('delete.SifatSurat');

    //manajemen->sifat surat
    Route::get('/indexInstansi', [App\Http\Controllers\ManajemenController::class, 'indexInstansi'])->name('index.Instansi');
    Route::get('/getInstansi', [App\Http\Controllers\ManajemenController::class, 'getInstansi'])->name('get.Instansi');
    Route::get('/createInstansi', [App\Http\Controllers\ManajemenController::class, 'createInstansi'])->name('create.Instansi');
    Route::post('/storeInstansi', [App\Http\Controllers\ManajemenController::class, 'storeInstansi'])->name('store.Instansi');
    Route::get('/editInstansi/{id}', [App\Http\Controllers\ManajemenController::class, 'editInstansi'])->name('edit.Instansi');
    Route::put('/updateInstansi/{id}', [App\Http\Controllers\ManajemenController::class, 'updateInstansi'])->name('update.Instansi');
    Route::delete('/deleteInstansi/{id}', [App\Http\Controllers\ManajemenController::class, 'deleteInstansi'])->name('delete.Instansi');
});
