<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::all();
        $data = Reservasi::with('lapangan')
            ->where('status', 'Ditunda')
            ->get();

        return view('home.home', [
            'data' => $data,
            'lapangan' => $lapangan
        ]);
    }

    // public function showHome()
    // {
    //     // $data = DB::table('tbl_reservasi')->select('tbl_reservasi.tanggal', 'tbl_reservasi.waktu_mulai', 'tbl_reservasi.waktu_selesai', 'tbl_lapangan.namalapangan as namalapangan')->where('status', '=', 'Lunas')->join('tbl_lapangan', 'tbl_reservasi.id_lapangan', '=', 'tbl_lapangan.id')->get();
    //     $data = DB::table('tbl_reservasi')
    //         ->select('tbl_reservasi.tanggal', 'tbl_reservasi.waktu_mulai', 'tbl_reservasi.waktu_selesai', 'tbl_lapangan.namalapangan as namalapangan')
    //         ->where('status', '=', 'Lunas')
    //         ->join('tbl_lapangan', 'tbl_reservasi.id_lapangan', '=', 'tbl_lapangan.id')
    //         ->get();

    //     return view('home.home', compact('data'));
    // }

    public function showReservasi()
    {
        return view('home.reservasi', [
            'lapangan' => Lapangan::all()
        ]);
    }

    // public function showReservasi()
    // {
    //     $tipeLapangan = DB::table('tbl_lapangan')->get();

    //     return view('home.reservasi', compact('tipeLapangan'));
    // }

    public function addReservasi(Request $request)
    {

        $validated = $request->validate([
            'nama' => 'required',
            'nomor_telepon' => 'required',
            'tipe_lapangan' => 'required',
            'tanggal' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $cekJadwal = DB::table('tbl_reservasi')
            ->where('id_lapangan', $request->tipe_lapangan)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('waktu_mulai', '<=', $request->waktu_mulai)
                        ->where('waktu_selesai', '>=', $request->waktu_mulai);
                })->orWhere(function ($q) use ($request) {
                    $q->where('waktu_mulai', '<=', $request->waktu_selesai)
                        ->where('waktu_selesai', '>=', $request->waktu_selesai);
                });
            })
            ->exists();


        if ($cekJadwal) {
            return redirect()->back()->with('add_gagal', 1);
        }

        $dataPelanggan = DB::table('tbl_pelanggan')->insertGetId([
            'nama' => $request->nama,
            'no_telepon' => $request->nomor_telepon,
        ]);



        DB::table('tbl_reservasi')->insert([
            'id_pelanggan' => $dataPelanggan,
            'id_lapangan' => $request->tipe_lapangan,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => 'Belum Lunas',
        ]);

        DB::table('tbl_notifikasi')->insert([
            'pesan' => 'Ada reservasi baru',
        ]);

        return redirect()->route('home')->with('success', 'Reservasi berhasil dibuat');
    }
}
