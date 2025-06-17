<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;

class DashboardController extends Controller
{
    public function index()
    {
        $booking = Reservasi::where('status', 'Ditunda')->get();

        return view('dashboard.home', [
            'booking' => $booking
        ]);
    }

    // public function index()
    // {
    //     $booking = DB::table('tbl_reservasi')->where('status', '=', 'Lunas')->join('tbl_lapangan', 'tbl_lapangan.id', '=', 'tbl_reservasi.id_lapangan')->get();
    //     return view('dashboard.home', ['booking' => $booking]);
    // }

    public function profil()
    {
        return view('dashboard.profil');
    }
}
