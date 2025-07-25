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

    public function showReservasi()
    {
        return view('home.reservasi', [
            'lapangan' => Lapangan::all()
        ]);
    }

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
            ->when($request->except_id, function ($query) use ($request) {
                $query->where('id', '!=', $request->except_id);
            })
            ->get();

        $waktuTerpakai = [];

        foreach ($reservasi as $res) {
            $start = (int) explode(':', $res->waktu_mulai)[0];
            $end = (int) explode(':', $res->waktu_selesai)[0];

            for ($i = $start; $i < $end; $i++) {
                $waktuTerpakai[] = sprintf('%02d:00:00', $i);
            }
        }

        $hasil = $waktuReservasi->map(function ($jam) use ($waktuTerpakai) {
            return [
                'jam' => $jam,
                'disabled' => in_array($jam, $waktuTerpakai),
            ];
        });

        return response()->json($hasil);
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
        $snapPrice = $validated['tipe_pembayaran'] === 'dp' ? $totalHarga * 0.5 : $totalHarga;

        $orderId = 'RESV-' . time() . '-' . rand(100, 999);

        $snapToken = $this->createSnapToken($orderId, $snapPrice, $validated['nama'], $validated['email'], $validated['nomor_telepon']);

        $reservasi = Reservasi::create([
            'order_id' => $orderId,
            'snap_token' => $snapToken,
            'pelanggan_id' => $pelanggan->id,
            'lapangan_id' => $validated['lapangan_id'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            // 'metode_pembayaran' => $validated['metode_pembayaran'],
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
            'expiry' => [
                'start_time' => date("Y-m-d H:i:s O"),
                'unit' => 'minute',
                'duration' => 5
            ]
        ];

        return Snap::getSnapToken($params);
    }
    
    public function showDetailReservasi($order_id)
    {
        $reservasi = Reservasi::with('lapangan', 'pelanggan', 'pembayaran.pembayaranDetail')->where('order_id', $order_id)->firstOrFail();

        return view('home.detail_reservasi', compact('reservasi'));
    }
}
