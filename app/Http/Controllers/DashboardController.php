<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $booking = DB::table('tbl_reservasi')->where('status', '=', 'Lunas')->join('tbl_lapangan', 'tbl_lapangan.id', '=', 'tbl_reservasi.id_lapangan')->get();
        return view('dashboard.home', ['booking' => $booking]);
    }

    public function profil()
    {
        return view('dashboard.profil');
    }
}
