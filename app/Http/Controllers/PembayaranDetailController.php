<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\PembayaranDetail;
use App\Http\Controllers\Controller;

class PembayaranDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reservasi = Reservasi::findOrFail($request->reservasi_id);

        $request->validate([
            'reservasi_id' => 'required|exists:reservasis,id',
            'jumlah_pembayaran' => 'required|numeric|min:1000',
            'metode_pembayaran' => 'required|string|max:64',
        ]);

        $pembayaran = Pembayaran::firstOrCreate(
            ['reservasi_id' => $reservasi->id],
            [
                'tanggal_pembayaran' => now(),
                'total_pembayaran' => 0,
                'sisa_pembayaran' => 0,
                'status_pembayaran' => 'Belum Lunas',
            ]
        );

        PembayaranDetail::create([
            'pembayaran_id' => $pembayaran->id,
            'tanggal_pembayaran' => now(),
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        $totalDetail = $pembayaran->pembayaranDetail()->sum('jumlah_pembayaran');

        $harga = $reservasi->lapangan->price;
        $waktuMulai = intval(substr($reservasi->waktu_mulai, 0, 2));
        $waktuSelesai = intval(substr($reservasi->waktu_selesai, 0, 2));
        $durasi = $waktuSelesai - $waktuMulai;
        $totalHarga = $harga * $durasi;

        $sisa = max($totalHarga - $totalDetail, 0);

        $pembayaran->update([
            'tanggal_pembayaran' => now(),
            'total_pembayaran' => $totalHarga,
            'sisa_pembayaran' => $sisa,
            'status_pembayaran' => $sisa == 0 ? 'Lunas' : 'Belum Lunas',
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
