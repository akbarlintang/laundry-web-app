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

Route::get('/','LandingPageController@cekNota');
Route::get('/cek-nota','LandingPageController@cekNota');
Route::post('/transaksi/cari', 'TransaksiController@cari')->name('transaksi.cari');
Route::get('/transaksi/cetak/{id}', 'TransaksiController@cetak')->name('transaksi.cetak');

Route::get('/dashboard','DashboardController@index');

Route::group(['prefix' => 'admin'], function(){
    Route::get('/','DashboardController@index');

    Route::get('login', 'LoginController@login')->name('admin.login');
    Route::post('custom-login', 'LoginController@customLogin')->name('login.custom');
    Route::get('logout', 'LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => ['auth:web']], function(){
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
        Route::post('/dashboard/filter', 'DashboardController@filter')->name('dashboard.filter');

        // Transaksi
        Route::get('/transaksi', 'TransaksiController@index')->name('transaksi.index');
        Route::post('/transaksi', 'TransaksiController@store')->name('transaksi.store');
        Route::post('/transaksi/{id}', 'TransaksiController@update')->name('transaksi.update');
        Route::delete('/transaksi/{id}', 'TransaksiController@delete')->name('transaksi.delete');
        Route::get('/transaksi/tambah', 'TransaksiController@create')->name('transaksi.tambah');
        Route::get('/transaksi/edit/{id}', 'TransaksiController@edit')->name('transaksi.edit');
        Route::post('/transaksi/status/{id}', 'TransaksiController@updateStatus')->name('transaksi.updateStatus');
        Route::post('/transaksi/pembayaran/{id}', 'TransaksiController@updatePembayaran')->name('transaksi.updatePembayaran');
        Route::delete('/transaksi/file/{id}/{index}', 'TransaksiController@deleteFile')->name('transaksi.file.delete');
        Route::get('/transaksi/datatable', 'TransaksiController@datatable')->name('transaksi.datatable');
        Route::get('/transaksi/download/{id}/{index}', 'TransaksiController@download')->name('transaksi.download');
        Route::get('/transaksi/cetak/{id}', 'TransaksiController@cetak')->name('transaksi.cetak');

        // Pemasukan
        Route::get('/pemasukan', 'PemasukanController@index')->name('pemasukan.index');
        Route::post('/pemasukan/filter', 'PemasukanController@filter')->name('pemasukan.filter');
        Route::get('/pemasukan/total', 'PemasukanController@total')->name('pemasukan.total');
        Route::get('/pemasukan/datatable', 'PemasukanController@datatable')->name('pemasukan.datatable');
        Route::get('/pemasukan/export_excel', 'PemasukanController@export')->name('pemasukan.export');

        // Pengeluaran
        Route::get('/pengeluaran', 'PengeluaranController@index')->name('pengeluaran.index');
        Route::post('/pengeluaran', 'PengeluaranController@store')->name('pengeluaran.store');
        Route::post('/pengeluaran/{id}', 'PengeluaranController@update')->name('pengeluaran.update');
        Route::delete('/pengeluaran/{id}', 'PengeluaranController@delete')->name('pengeluaran.delete');
        Route::get('/pengeluaran/tambah', 'PengeluaranController@create')->name('pengeluaran.tambah');
        Route::get('/pengeluaran/edit/{id}', 'PengeluaranController@edit')->name('pengeluaran.edit');
        Route::post('/pengeluaran/filter/tanggal', 'PengeluaranController@filter')->name('pengeluaran.filter');
        Route::get('/pengeluaran/total', 'PengeluaranController@total')->name('pengeluaran.total');
        Route::delete('/pengeluaran/file/{id}/{index}', 'PengeluaranController@deleteFile')->name('pengeluaran.file.delete');
        Route::get('/pengeluaran/datatable', 'PengeluaranController@datatable')->name('pengeluaran.datatable');
        Route::get('/pengeluaran/download/{id}/{index}', 'PengeluaranController@download')->name('pengeluaran.download');
        Route::get('/pengeluaran/export_excel', 'PengeluaranController@export')->name('pengeluaran.export');

        // Laporan keuangan
        Route::get('/laporan-keuangan', 'LaporanKeuanganController@index')->name('laporan-keuangan.index');
        Route::post('/laporan-keuangan/filter', 'LaporanKeuanganController@filter')->name('laporan-keuangan.filter');
        Route::get('/laporan-keuangan/total', 'LaporanKeuanganController@total')->name('laporan-keuangan.total');
        Route::get('/laporan-keuangan/datatable', 'LaporanKeuanganController@datatable')->name('laporan-keuangan.datatable');
        Route::get('/laporan-keuangan/export_excel', 'LaporanKeuanganController@export')->name('laporan-keuangan.export');

        // Pelanggan
        Route::get('/pelanggan', 'PelangganController@index')->name('pelanggan.index');
        Route::post('/pelanggan', 'PelangganController@store')->name('pelanggan.store');
        Route::post('/pelanggan/{id}', 'PelangganController@update')->name('pelanggan.update');
        Route::delete('/pelanggan/{id}', 'PelangganController@delete')->name('pelanggan.delete');
        Route::get('/pelanggan/datatable', 'PelangganController@datatable')->name('pelanggan.datatable');

        Route::group(['prefix' => 'master'], function(){
            // Role
            Route::get('/role', 'RoleController@index')->name('role.index');
            Route::post('/role', 'RoleController@store')->name('role.store');
            Route::post('/role/{id}', 'RoleController@update')->name('role.update');
            Route::delete('/role/{id}', 'RoleController@delete')->name('role.delete');
            Route::get('/role/datatable', 'RoleController@datatable')->name('role.datatable');

            // Karyawan
            Route::get('/karyawan', 'KaryawanController@index')->name('karyawan.index');
            Route::post('/karyawan', 'KaryawanController@store')->name('karyawan.store');
            Route::post('/karyawan/{id}', 'KaryawanController@update')->name('karyawan.update');
            Route::delete('/karyawan/{id}', 'KaryawanController@delete')->name('karyawan.delete');
            Route::get('/karyawan/datatable', 'KaryawanController@datatable')->name('karyawan.datatable');

            // Paket
            Route::get('/paket', 'PaketController@index')->name('paket.index');
            Route::post('/paket', 'PaketController@store')->name('paket.store');
            Route::post('/paket/{id}', 'PaketController@update')->name('paket.update');
            Route::delete('/paket/{id}', 'PaketController@delete')->name('paket.delete');
            Route::get('/paket/get/{id}', 'PaketController@get')->name('paket.get');
            Route::get('/paket/datatable', 'PaketController@datatable')->name('paket.datatable');

            // Jenis Cucian
            Route::get('/jenis', 'JenisController@index')->name('jenis.index');
            Route::post('/jenis', 'JenisController@store')->name('jenis.store');
            Route::post('/jenis/{id}', 'JenisController@update')->name('jenis.update');
            Route::delete('/jenis/{id}', 'JenisController@delete')->name('jenis.delete');
            Route::get('/jenis/datatable', 'JenisController@datatable')->name('jenis.datatable');

            // Status
            Route::get('/status', 'StatusController@index')->name('status.index');
            Route::post('/status', 'StatusController@store')->name('status.store');
            Route::post('/status/{id}', 'StatusController@update')->name('status.update');
            Route::delete('/status/{id}', 'StatusController@delete')->name('status.delete');
            Route::get('/status/get/{id}', 'StatusController@get')->name('status.get');
            Route::get('/status/datatable', 'StatusController@datatable')->name('status.datatable');

            // Konfigurasi Landing
            Route::get('/config', 'ConfigController@index')->name('config.index');
            Route::post('/config/{id}', 'ConfigController@update')->name('config.update');
            Route::get('/config/get/{id}', 'ConfigController@get')->name('config.get');
            Route::get('/config/datatable', 'ConfigController@datatable')->name('config.datatable');
        });

        Route::group(['prefix' => 'akun'], function(){
            Route::get('/pengaturan', 'AkunController@index')->name('pengaturan.index');
            Route::post('/pengaturan/general', 'AkunController@generalUpdate')->name('pengaturan.general.update');
            Route::post('/pengaturan/password', 'AkunController@passwordUpdate')->name('pengaturan.password.update');
        });
    });
});

// 404 for undefined routes
Route::any('/{page?}',function(){
    return View::make('pages.error-pages.error-404');
})->where('page','.*');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
