<?php

use Illuminate\Support\Facades\Route;
use App\User;
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
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/', function () {
        if (Auth::guest()) {
            return redirect()->route('login');
        } else {
            return redirect()->route('home');
        }
    });
});

Route::get('/about', function () {
    $anggota = User::all();

    return view('about', compact('anggota'));
})->middleware('auth')->name('about');

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');

Route::post('/password/compare', 'Auth\ResetPasswordController@compare')->name('passowrd.compare');
Route::get('/password/reset/{id}/{token}', 'Auth\ResetPasswordController@viewResetPasswordBaru');
Route::put('/password/{id}', 'Auth\ResetPasswordController@resetPasswordBaru')->name('about')->name('password.telegram');

Route::resource('admin-anggota', 'DataAnggotaController')->middleware('auth', 'can:isAdmin');
Route::get('/edit/password', 'DataAnggotaController@password')->middleware('auth')->name('edit.password');
Route::patch('/update/password', 'DataAnggotaController@updatePassword')->middleware('auth')->name('update.password');
Route::get('/edit/email/{id}', 'DataAnggotaController@email')->middleware('auth')->name('edit.email');
Route::put('/update/email/{id}', 'DataAnggotaController@updateEmail')->middleware('auth')->name('update.email');
Route::get('/edit/level/{id}', 'DataAnggotaController@role')->middleware('auth', 'can:isAdmin')->name('edit.level');
Route::put('/update/level/{id}', 'DataAnggotaController@updateRole')->middleware('auth')->name('update.level');

Route::resource('anggota', 'API\AnggotaController')->middleware('auth', 'can:isUser');
Route::get('/update/to/admin/{id}', 'API\AnggotaController@updateRole')->middleware('auth')->name('upgrade.admin');

Route::resource('admin-kas-hmj', 'KasHmjController')->middleware('auth', 'can:isAdmin');

Route::resource('kas-hmj', 'API\KasHmjController')->middleware('auth', 'can:isUser');

Route::resource('admin-kas-ph', 'KasPhController')->middleware('auth', 'can:isAdmin');

Route::resource('kas-ph', 'API\KasPhController')->middleware('auth', 'can:isUser');

Route::resource('admin-laporan-kas', 'LaporanKasController')->middleware('auth', 'can:isAdmin');
Route::post('/laporankas-ph/store/mobile', 'LaporanKasController@storeMobile')->middleware('auth')->name('simpan.mobile');
Route::get('/laporankas-ph/excel', 'LaporanKasController@export')->middleware('auth')->name('export.excel');

Route::resource('laporan-kas', 'API\LaporanKasController')->middleware('auth', 'can:isUser');
Route::get('/laporankas-ph/pdf', 'API\LaporanKasController@downloadPdf')->middleware('auth')->name('export.pdf');

Route::resource('reminder', 'ReminderController')->middleware('auth', 'can:isAdmin');
Route::get('/findNomorPenerima/{id}','ReminderController@findNomorPenerima')->middleware('auth');
Route::get('/findIuranPh','ReminderController@findIuranPh')->middleware('auth')->name('find.iuran');

Route::resource('notifikasi', 'NotifikasiController')->middleware('auth', 'can:isAdmin');
Route::get('/notifikasi/konfirmasi/bayar', 'NotifikasiController@indexBayar')->middleware('auth', 'can:isAdmin')->name('notifikasi.bayar');
Route::get('/notifikasi/konfirmasi/lunas', 'NotifikasiController@indexLunas')->middleware('auth', 'can:isAdmin')->name('notifikasi.lunas');
Route::get('/notifikasi/konfirmasi/admin', 'NotifikasiController@indexAdmin')->middleware('auth', 'can:isAdmin')->name('notifikasi.admin');
Route::get('/notifikasi/konfirmasi/denda', 'NotifikasiController@indexDenda')->middleware('auth', 'can:isAdmin')->name('notifikasi.denda');
Route::get('/notifikasi/admin/{id}', 'NotifikasiController@beAdmin')->middleware('auth')->name('notifikasi.upgrade.admin');
Route::get('/notifikasi/user/{id}', 'NotifikasiController@beUser')->middleware('auth')->name('notifikasi.user');
Route::put('/notifikasi/tidak/{id}', 'NotifikasiController@tidak')->middleware('auth')->name('notifikasi.update.tidak');
Route::put('/notifikasi/lunas/{id}', 'NotifikasiController@lunas')->middleware('auth')->name('notifikasi.update.lunas');
Route::get('/notifikasi/denda/{id}', 'NotifikasiController@denda')->middleware('auth')->name('notifikasi.update.denda');

Route::get('/deep-linking', 'HomeController@deepLinking');

Route::post(config('telegram.bots.common.token') . '/webhook', 'ReminderController@handleRequest');