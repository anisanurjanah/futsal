<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembayaranDetailController;

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

Route::get('/', [HomeController::class, 'index'])->middleware('guest')->name('home');

Route::get('/reservasi', [HomeController::class, 'showReservasi'])->name('reservasi');
Route::get('/reservasi/{order_id}', [HomeController::class, 'showDetailReservasi'])->name('detail_reservasi');

Route::post('/reservasi/pembayaran', [HomeController::class, 'storeReservasi'])->name('reservasi/pembayaran');

Route::post('/cek-jadwal', [HomeController::class, 'getAvailableWaktu']);


// DASHBOARD
Route::get('/login', [AuthController::class, 'index']);

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'AdminMiddleware'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');

    Route::resource('/dashboard/pengguna', UserController::class);
    Route::resource('/dashboard/pelanggan', PelangganController::class);
    Route::resource('/dashboard/lapangan', LapanganController::class);
    Route::resource('/dashboard/reservasi', ReservasiController::class);
    Route::resource('/dashboard/pembayaran', PembayaranController::class);
    Route::resource('/dashboard/pembayarandetails', PembayaranDetailController::class);

    Route::patch('/dashboard/reservasi/{id}/cancel', [ReservasiController::class, 'cancelReservasi']);
    Route::get('/dashboard/keuangan', [LaporanController::class, 'keuangan']);
    Route::get('/dashboard/keuangan/export-pdf', [LaporanController::class, 'exportPDF']);
});
