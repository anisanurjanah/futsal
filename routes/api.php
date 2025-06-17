<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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



// Route::get('/notifikasi', function () {
//     $notifikasi = DB::table('tbl_notifikasi')->where('is_read', '=', 0)->get();
//     foreach ($notifikasi as $notif) {
//         DB::table('tbl_notifikasi')->where('id', $notif->id)->update(['is_read' => 1]);
//     }
//     if ($notifikasi->isEmpty()) {
//         return response()->json([
//             "status" => "Tidak ada notifikasi",
//             "is_read" => true,
//         ]);
//     } else {
//         return response()->json($notifikasi);
//     }
// })->name('notifikasi');
