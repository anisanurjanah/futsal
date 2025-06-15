<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Lapangan;
use App\Models\Pelanggan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $member = Pelanggan::all();
        $lapangan = Lapangan::all();

        return view('booking.add', ['member' => $member, 'lapangan' => $lapangan]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $cekJadwal = DB::table('tbl_reservasi')
            ->where('id_lapangan', $request->idlapangan)
            ->where('tanggal', $request->tanggal)

            ->where(function ($query) use ($request) {
                $query
                    // 1. waktu_mulai input berada di dalam jadwal lama
                    ->where(function ($q) use ($request) {
                        $q->where('waktu_mulai', '<=', $request->waktu_mulai)
                            ->where('waktu_selesai', '>', $request->waktu_mulai); // pakai > supaya sama tidak bentrok
                    })
                    // 2. waktu_selesai input berada di dalam jadwal lama
                    ->orWhere(function ($q) use ($request) {
                        $q->where('waktu_mulai', '<', $request->waktu_selesai) // pakai < supaya sama tidak bentrok
                            ->where('waktu_selesai', '>=', $request->waktu_selesai);
                    })
                    // 3. jadwal lama di dalam input (input mencakup jadwal lama)
                    ->orWhere(function ($q) use ($request) {
                        $q->where('waktu_mulai', '>=', $request->waktu_mulai)
                            ->where('waktu_selesai', '<=', $request->waktu_selesai);
                    });
            })
            ->exists();


        if ($cekJadwal) {
            return redirect()->back()->with('add_gagal', 1);
        }

        $time1 = new DateTime($request->waktu_mulai);
        $time2 = new DateTime($request->waktu_selesai);
        $interval = $time2->diff($time1);
        $durasi = (int)$interval->format('%h');

        if ($request->statustransaksi == 'Belum Lunas') {
            DB::table('tbl_notifikasi')->insert([
                'pesan' => 'Ada reservasi baru yang belum lunas',
            ]);
        }


        DB::table('tbl_reservasi')->insert([
            'id_pelanggan' => $request->idmember,
            'id_lapangan' => $request->idlapangan,
            'status' => $request->statustransaksi,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return redirect('booking/index')->with('add_sukses', 1);
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
        $row = Reservasi::with(['pelanggan', 'lapangan'])->findOrFail($id);
        $pelanggan = Pelanggan::all();
        $lapangan = Lapangan::all();

        return view('booking.edit', [
            'row' => $row,
            'pelanggan' => $pelanggan,
            'lapangan' => $lapangan,
        ]);
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
        $cekJadwal = DB::table('tbl_reservasi')
            ->where('id', '!=', $request->id)
            ->where('id_lapangan', $request->id_lapangan)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {
                $query
                    // 1. waktu_mulai input berada di dalam jadwal lama
                    ->where(function ($q) use ($request) {
                        $q->where('waktu_mulai', '<=', $request->waktu_mulai)
                            ->where('waktu_selesai', '>', $request->waktu_mulai); // pakai > supaya sama tidak bentrok
                    })
                    // 2. waktu_selesai input berada di dalam jadwal lama
                    ->orWhere(function ($q) use ($request) {
                        $q->where('waktu_mulai', '<', $request->waktu_selesai) // pakai < supaya sama tidak bentrok
                            ->where('waktu_selesai', '>=', $request->waktu_selesai);
                    })
                    // 3. jadwal lama di dalam input (input mencakup jadwal lama)
                    ->orWhere(function ($q) use ($request) {
                        $q->where('waktu_mulai', '>=', $request->waktu_mulai)
                            ->where('waktu_selesai', '<=', $request->waktu_selesai);
                    });
            })
            ->exists();



        if ($cekJadwal) {
            return redirect()->back()->with('edit_gagal', 1);
        }

        DB::table('tbl_reservasi')
            ->where('id', $request->id)
            ->update([
                'id_lapangan' => $request->id_lapangan,
                'status' => $request->statustransaksi,
                'tanggal' => $request->tanggal,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
            ]);

        return redirect('booking/index')->with('edit_sukses', 1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('tbl_reservasi')->where('id', $id)->delete();
        return redirect()->back()->with('delete_sukses', 1);
    }
}
