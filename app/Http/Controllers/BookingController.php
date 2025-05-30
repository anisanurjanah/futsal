<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_reservasi')
            ->join('tbl_pelanggan', 'tbl_pelanggan.id', '=', 'tbl_reservasi.id_pelanggan')
            ->join('tbl_lapangan', 'tbl_lapangan.id', '=', 'tbl_reservasi.id_lapangan')
            ->select('tbl_reservasi.*', 'tbl_pelanggan.nama', 'tbl_lapangan.namalapangan', 'tbl_lapangan.hargaperjam')
            ->get();


        $result = [];

        foreach ($data as $item) {

            $time1 = new DateTime($item->waktu_mulai);
            $time2 = new DateTime($item->waktu_selesai);
            $interval = $time2->diff($time1);
            $durasi = (int)$interval->format('%h');


            $result[] = [
                'id' => $item->id,
                'nama' => $item->nama,
                'namalapangan' => $item->namalapangan,
                'durasi' => $durasi,
                'hargaperjam' => $item->hargaperjam,
                'tanggal' => $item->tanggal,
                'jam_mulai' => $item->waktu_mulai,
                'jam_selesai' => $item->waktu_selesai,
                'statustransaksi' => $item->status,
            ];
        }

        return view('booking.index', ['data' => $result]);
    }

    public function create()
    {
        $member = DB::table('tbl_pelanggan')->get();
        $lapangan = DB::table('tbl_lapangan')->get();

        return view('booking.add', ['member' => $member, 'lapangan' => $lapangan]);
    }

    public function add(Request $request)
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

    public function edit($id)
    {
        $row = DB::table('tbl_reservasi')
            ->join('tbl_pelanggan', 'tbl_pelanggan.id', '=', 'tbl_reservasi.id_pelanggan')
            ->join('tbl_lapangan', 'tbl_lapangan.id', '=', 'tbl_reservasi.id_lapangan')
            ->select('tbl_reservasi.*', 'tbl_pelanggan.nama', 'tbl_lapangan.namalapangan')
            ->where('tbl_reservasi.id', $id)
            ->first();

        $pelanggan = DB::table('tbl_pelanggan')->get();
        $lapangan = DB::table('tbl_lapangan')->get();

        return view('booking.edit', [
            'row' => $row,
            'pelanggan' => $pelanggan,
            'lapangan' => $lapangan,
        ]);
    }

    public function update(Request $request)
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

    public function delete($id)
    {
        DB::table('tbl_reservasi')->where('id', $id)->delete();
        return redirect()->back()->with('delete_sukses', 1);
    }
}
