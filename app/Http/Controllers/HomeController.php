<?php

namespace App\Http\Controllers;

use Svg\Tag\Rect;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Lapangan;
use App\Models\Pelanggan;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\PembayaranDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.sanitized');
        Config::$is3ds = config('midtrans.3ds');
    }

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

    public function getAvailableWaktu(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $lapanganId = $request->input('lapangan_id');

        $waktuReservasi = collect();
        for ($i = 10; $i < 21; $i++) {
            $jam = sprintf('%02d:00:00', $i);
            $waktuReservasi->push($jam);
        }

        $reservasi = Reservasi::where('tanggal', $tanggal)
            ->where('lapangan_id', $lapanganId)
            ->get();

        $waktuTerpakai = [];

        foreach ($reservasi as $res) {
            $start = (int) explode(':', $res->waktu_mulai)[0];
            $end = (int) explode(':', $res->waktu_selesai)[0];

            for ($i = $start; $i <= $end; $i++) {
                $waktuTerpakai[] = sprintf('%02d:00:00', $i);
            }
        }

        $waktuTersedia = $waktuReservasi->diff($waktuTerpakai)->values();

        return response()->json($waktuTersedia);
    }

    public function storeReservasi(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'nama'            => 'required|string|max:64',
            'email'            => 'required|email|max:32',
            'nomor_telepon'   => 'required|string|max:15',
            'tanggal'         => 'required|date|after_or_equal:today',
            'waktu_mulai'     => 'required|date_format:H:i:s',
            'waktu_selesai'   => 'required|date_format:H:i:s|after:waktu_mulai',
            'tipe_pembayaran' => 'required|in:dp,lunas',
            // 'metode_pembayaran'  => 'required|in:bank_transfer,gopay,qris',
        ], [
            'lapangan_id.required'  => 'Tipe lapangan harus dipilih.',
            'nama.required'           => 'Nama tidak boleh kosong.',
            'email.required'           => 'Email tidak boleh kosong.',
            'nomor_telepon.required'  => 'Nomor telepon tidak boleh kosong.',
            'tanggal.after_or_equal'  => 'Tanggal harus hari ini atau setelahnya.',
            'waktu_selesai.after'     => 'Waktu selesai harus lebih dari waktu mulai.',
            'tipe_pembayaran.required' => 'Tipe pembayaran harus dipilih.',
            'tipe_pembayaran.in' => 'Tipe pembayaran tidak valid.',
            // 'metode_pembayaran.required' => 'Metode pembayaran harus dipilih.',
            // 'metode_pembayaran.in'       => 'Metode pembayaran tidak valid.',
        ]);

        if ($this->checkReservasiTime($validated['tanggal'], $validated['lapangan_id'], $validated['waktu_mulai'], $validated['waktu_selesai'])) {
            return redirect()->back()->with('add_gagal', 'Waktu tersebut sudah dipesan. Silakan pilih waktu lain.');
        }
    
        // Cek data pelanggan
        $pelanggan = Pelanggan::where('email', $validated['email'])
                  ->orWhere('phone', $validated['nomor_telepon'])
                  ->first();
    
        if (!$pelanggan) {
            $pelanggan = Pelanggan::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'phone' => $validated['nomor_telepon'],
            ]);
        }

        $lapangan = Lapangan::find($validated['lapangan_id']);
        $hargaPerJam = $lapangan->price;
        $durasi = (int) explode(':', $validated['waktu_selesai'])[0] - (int) explode(':', $validated['waktu_mulai'])[0];
        $totalHarga = $hargaPerJam * $durasi;

        $orderId = 'RESV-' . time() . '-' . rand(100, 999);

        $snapToken = $this->createSnapToken($orderId, $totalHarga, $validated['nama'], $validated['email'], $validated['nomor_telepon']);

        $reservasi = Reservasi::create([
            'order_id' => $orderId,
            'snap_token' => $snapToken,
            'pelanggan_id' => $pelanggan->id,
            'lapangan_id' => $validated['lapangan_id'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status' => 'Ditunda',
            'total_harga' => $totalHarga,
        ]);

        $pembayaranSekarang = $totalHarga;
        $sisaPembayaran = 0;

        if ($validated['tipe_pembayaran'] === 'dp') {
            $pembayaranSekarang = $totalHarga * 0.5;
            $sisaPembayaran = $totalHarga - $pembayaranSekarang;
        }

        $pembayaran = Pembayaran::create([
            'reservasi_id' => $reservasi->id,
            'tanggal_pembayaran' => now()->toDateString(),
            'total_pembayaran' => $totalHarga,
            'sisa_pembayaran' => $sisaPembayaran,
            'status_pembayaran' => $sisaPembayaran > 0 ? 'Belum Lunas' : 'Lunas'
        ]);

        PembayaranDetail::create([
            'pembayaran_id' => $pembayaran->id,
            'tanggal_pembayaran' => now()->toDateString(),
            'jumlah_pembayaran' => $pembayaranSekarang,
            'metode_pembayaran' => 'midtrans',
        ]);

        return view('home.payment', [
            'snapToken' => $snapToken,
            'reservasi' => $reservasi,
        ]);
    }

    public function checkReservasiTime($tanggal, $lapangan, $waktuMulaiInput, $waktuSelesaiInput)
    {
        $reservasi = Reservasi::where('tanggal', $tanggal)
            ->where('lapangan_id', $lapangan)
            ->get();

        foreach ($reservasi as $res) {
            if (
                ($waktuMulaiInput >= $res->waktu_mulai && $waktuMulaiInput < $res->waktu_selesai) ||
                ($waktuSelesaiInput > $res->waktu_mulai && $waktuSelesaiInput <= $res->waktu_selesai) ||
                ($waktuMulaiInput <= $res->waktu_mulai && $waktuSelesaiInput >= $res->waktu_selesai)
            ) {
                return true;
            }
        }

        return false;
    }

    
    public function createSnapToken($orderId, $grossAmount, $customerName, $email, $phone)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $customerName,
                'email' => $email,
                'phone' => $phone,
            ],
            'enabled_payments' => ['gopay', 'bank_transfer', 'qris'],
        ];

        return Snap::getSnapToken($params);
    }

    // public function addReservasi(Request $request)
    // {

    //     $validated = $request->validate([
    //         'nama' => 'required',
    //         'nomor_telepon' => 'required',
    //         'tipe_lapangan' => 'required',
    //         'tanggal' => 'required',
    //         'waktu_mulai' => 'required',
    //         'waktu_selesai' => 'required',
    //     ]);

    //     $cekJadwal = DB::table('tbl_reservasi')
    //         ->where('id_lapangan', $request->tipe_lapangan)
    //         ->where('tanggal', $request->tanggal)
    //         ->where(function ($query) use ($request) {
    //             $query->where(function ($q) use ($request) {
    //                 $q->where('waktu_mulai', '<=', $request->waktu_mulai)
    //                     ->where('waktu_selesai', '>=', $request->waktu_mulai);
    //             })->orWhere(function ($q) use ($request) {
    //                 $q->where('waktu_mulai', '<=', $request->waktu_selesai)
    //                     ->where('waktu_selesai', '>=', $request->waktu_selesai);
    //             });
    //         })
    //         ->exists();


    //     if ($cekJadwal) {
    //         return redirect()->back()->with('add_gagal', 1);
    //     }

    //     $dataPelanggan = DB::table('tbl_pelanggan')->insertGetId([
    //         'nama' => $request->nama,
    //         'no_telepon' => $request->nomor_telepon,
    //     ]);

    //     DB::table('tbl_reservasi')->insert([
    //         'id_pelanggan' => $dataPelanggan,
    //         'id_lapangan' => $request->tipe_lapangan,
    //         'tanggal' => $request->tanggal,
    //         'waktu_mulai' => $request->waktu_mulai,
    //         'waktu_selesai' => $request->waktu_selesai,
    //         'status' => 'Belum Lunas',
    //     ]);

    //     DB::table('tbl_notifikasi')->insert([
    //         'pesan' => 'Ada reservasi baru',
    //     ]);

    //     return redirect()->route('home')->with('success', 'Reservasi berhasil dibuat');
    // }

    public function showDetailReservasi()
    {
        return view('home.detail_reservasi');
    }
}
