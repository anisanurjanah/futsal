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

Route::get('/', 'HomeController@showHome')->name('home');
Route::get('/reservasi', 'HomeController@showReservasi')->name('reservasi');
Route::post('/reservasi/add', 'HomeController@addReservasi')->name('reservasi/add');

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('login', 'AuthController@login')->name('login');
Route::get('logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'AdminMiddleware'], function () {
    //Home
    Route::get('dashboard', 'DashboardController@index')->name('dashboard_admin');
    Route::get('profil', 'DashboardController@profil')->name('profil');

    // USER
    Route::get('pengguna/index', 'PenggunaController@index')->name('pengguna/index');
    Route::get('pengguna/add', 'PenggunaController@create')->name('add');
    Route::post('pengguna/add', 'PenggunaController@add')->name('add');
    Route::get('pengguna/edit/{id}', 'PenggunaController@edit')->name('pengguna/edit');
    Route::post('pengguna/edit', 'PenggunaController@update')->name('pengguna/edit');
    Route::get('pengguna/pengguna/delete/{id}', 'PenggunaController@delete')->name('pengguna/pengguna/delete');

    // LAPANGAN
    Route::get('lapangan/index', 'LapanganController@index')->name('lapangan/index');
    Route::get('lapangan/add', 'LapanganController@create')->name('add');
    Route::post('lapangan/add', 'LapanganController@add')->name('add');
    Route::get('lapangan/edit/{id}', 'LapanganController@edit')->name('lapangan/edit');
    Route::post('lapangan/edit', 'LapanganController@update')->name('lapangan/edit');
    Route::get('lapangan/lapangan/delete/{id}', 'LapanganController@delete')->name('lapangan/lapangan/delete');

    // MEMBER
    Route::get('member/index', 'MemberController@index')->name('member/index');
    Route::get('member/add', 'MemberController@create')->name('add');
    Route::post('member/add', 'MemberController@add')->name('add');
    Route::get('member/edit/{id}', 'MemberController@edit')->name('member/edit');
    Route::post('member/edit', 'MemberController@update')->name('member/edit');
    Route::get('member/member/delete/{id}', 'MemberController@delete')->name('member/member/delete');

    // BOOKING
    Route::get('booking/index', 'BookingController@index')->name('booking/index');
    Route::get('booking/add', 'BookingController@create')->name('add');
    Route::post('booking/add', 'BookingController@add')->name('add');
    Route::get('booking/edit/{id}', 'BookingController@edit')->name('booking/edit');
    Route::post('booking/edit', 'BookingController@update')->name('booking/update');
    Route::get('booking/booking/delete/{id}', 'BookingController@delete')->name('booking/booking/delete');
    
    // PEMBAYARAN
    Route::get('pembayaran/index', 'BookingController@index')->name('pembayaran/index');
    Route::get('pembayaran/add', 'BookingController@create')->name('add');
    Route::post('pembayaran/add', 'BookingController@add')->name('add');
    Route::get('pembayaran/edit/{id}', 'BookingController@edit')->name('pembayaran/edit');
    Route::post('pembayaran/edit', 'BookingController@update')->name('pembayaran/update');
    Route::get('pembayaran/pembayaran/delete/{id}', 'BookingController@delete')->name('pembayaran/pembayaran/delete');
});
