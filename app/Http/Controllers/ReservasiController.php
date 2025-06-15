<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Reservasi::latest()->with(['pelanggan', 'lapangan', 'pembayaran'])->get();

        $result = [];
        foreach ($data as $item) {
            $time1 = new DateTime($item->waktu_mulai);
            $time2 = new DateTime($item->waktu_selesai);
            $interval = $time2->diff($time1);
            $durasi = (int)$interval->format('%h');

            $result[] = [
                'id' => $item->id,
                'nama' => $item->pelanggan->name,
                'nama_lapangan' => $item->lapangan->name,
                'durasi' => $durasi,
                'harga' => $item->lapangan->price,
                'tanggal' => $item->tanggal,
                'waktu_mulai' => $item->waktu_mulai,
                'waktu_selesai' => $item->waktu_selesai,
                'status_pembayaran' => $item->pembayaran->first()->status_pembayaran ?? '-',
            ];
        }

        return view('booking.index', ['data' => $result]);
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
        //
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
