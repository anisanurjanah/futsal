<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Lapangan;
use App\Models\Pelanggan;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PembayaranDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                'status' => $item->status,
                'status_pembayaran' => $item->pembayaran->status_pembayaran,
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
        $pelanggan = Pelanggan::all();
        $lapangan = Lapangan::all();
        $metodePembayaran = Pembayaran::METODE_PEMBAYARAN;

        return view('booking.add', [
            'pelanggan' => $pelanggan, 
            'lapangan' => $lapangan,
            'metodePembayaran' => $metodePembayaran,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tanggal'         => 'required|date|after_or_equal:today',
            'waktu_mulai'     => 'required|date_format:H:i:s',
            'waktu_selesai'   => 'required|date_format:H:i:s|after:waktu_mulai',
            'tipe_pembayaran' => 'required|in:dp,lunas',
            'jumlah_pembayaran' => 'required|numeric|min:0',
            'metode_pembayaran' => ['required', Rule::in(['Tunai', 'Bank Transfer', 'QRIS'])],
        ], [
            'lapangan_id.required'  => 'Lapangan harus dipilih.',
            'tanggal.after_or_equal'  => 'Tanggal harus hari ini atau setelahnya.',
            'waktu_selesai.after'     => 'Waktu selesai harus lebih dari waktu mulai.',
            'tipe_pembayaran.required' => 'Tipe pembayaran harus dipilih.',
            'tipe_pembayaran.in' => 'Tipe pembayaran tidak valid.',
            'metode_pembayaran.required' => 'Metode pembayaran harus dipilih.',
            'metode_pembayaran.in'       => 'Metode pembayaran tidak valid.',
        ]);

        if ($this->checkReservasiTime($validated['tanggal'], $validated['lapangan_id'], $validated['waktu_mulai'], $validated['waktu_selesai'])) {
            return redirect()->back()->with('add_gagal', 'Waktu tersebut sudah dipesan. Silakan pilih waktu lain.');
        }
    
        // Cek data pelanggan
        $pelanggan = Pelanggan::find($validated['pelanggan_id']);

        $lapangan = Lapangan::find($validated['lapangan_id']);
        $hargaPerJam = $lapangan->price;
        $durasi = (int) explode(':', $validated['waktu_selesai'])[0] - (int) explode(':', $validated['waktu_mulai'])[0];
        $totalHarga = $hargaPerJam * $durasi;

        $reservasi = Reservasi::create([
            'pelanggan_id' => $pelanggan->id,
            'lapangan_id' => $validated['lapangan_id'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'status' => 'Ditunda',
        ]);

        $pembayaranSekarang = $totalHarga;
        $sisaPembayaran = 0;

        if ($validated['tipe_pembayaran'] === 'dp') {
            $pembayaranSekarang = (int) str_replace('.', '', $validated['jumlah_pembayaran']);
            $sisaPembayaran = max(0, $totalHarga - $pembayaranSekarang);
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
            'metode_pembayaran' => $validated['metode_pembayaran'],
        ]);

        return redirect('/dashboard/reservasi')->with('add_sukses', 1);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Reservasi::with(['pelanggan', 'lapangan', 'pembayaran.pembayaranDetail'])->findOrFail($id);

        return view('booking.show', [
            'row' => $row,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Reservasi::with(['pelanggan', 'lapangan', 'pembayaran'])->findOrFail($id);
        $pelanggan = Pelanggan::all();
        $lapangan = Lapangan::all();
        $metodePembayaran = Pembayaran::METODE_PEMBAYARAN;

        return view('booking.edit', [
            'row' => $row,
            'pelanggan' => $pelanggan,
            'lapangan' => $lapangan,
            'metodePembayaran' => $metodePembayaran,
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
        // dd($request->all());

        $reservasi = Reservasi::findOrFail($id);
        $pembayaran = $reservasi->pembayaran;

        // Base rules
        $rules = [
            'lapangan_id' => 'required|exists:lapangans,id',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tanggal'         => 'required|date|after_or_equal:today',
            'waktu_mulai'     => 'required|date_format:H:i:s',
            'waktu_selesai'   => 'required|date_format:H:i:s|after:waktu_mulai',
            'jumlah_pembayaran' => 'required|numeric|min:0',
            'metode_pembayaran' => ['required', Rule::in(['Tunai', 'Bank Transfer', 'QRIS'])],
        ];

        $messages = [
            'lapangan_id.required'  => 'Lapangan harus dipilih.',
            'tanggal.after_or_equal'  => 'Tanggal harus hari ini atau setelahnya.',
            'waktu_selesai.after'     => 'Waktu selesai harus lebih dari waktu mulai.',
            'metode_pembayaran.required' => 'Metode pembayaran harus dipilih.',
            'metode_pembayaran.in'       => 'Metode pembayaran tidak valid.',
            'jumlah_pembayaran_baru.required' => 'Jumlah pembayaran baru harus diisi.',
            'metode_pembayaran_baru.required' => 'Metode pembayaran baru harus dipilih.',
        ];

        if ($pembayaran && $pembayaran->status_pembayaran === 'Belum Lunas') {
            $rules['jumlah_pembayaran_baru'] = 'required|numeric|min:0';
            $rules['metode_pembayaran_baru'] = ['required', Rule::in(['Tunai', 'Bank Transfer', 'QRIS'])];
        }

        $validated = $request->validate($rules, $messages);

        if ($this->checkReservasiTime($validated['tanggal'], $validated['lapangan_id'], $validated['waktu_mulai'], $validated['waktu_selesai'])) {
            return redirect()->back()->with('add_gagal', 'Waktu tersebut sudah dipesan. Silakan pilih waktu lain.');
        }
    
        // Cek data pelanggan
        $pelanggan = Pelanggan::find($validated['pelanggan_id']);
        
        $reservasi->update([
            'pelanggan_id' => $pelanggan->id,
            'lapangan_id' => $validated['lapangan_id'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'status' => 'Ditunda',
        ]);

        $lapangan = Lapangan::find($validated['lapangan_id']);
        $hargaPerJam = $lapangan->price;
        $durasi = (int) explode(':', $validated['waktu_selesai'])[0] - (int) explode(':', $validated['waktu_mulai'])[0];
        $totalHarga = $hargaPerJam * $durasi;
    
        if ($pembayaran) {
            $jumlahBaru = (int) str_replace('.', '', $validated['jumlah_pembayaran_baru']);

            $pembayaran->pembayaranDetail()->create([
                'pembayaran_id' => $pembayaran->id,
                'tanggal_pembayaran' => now()->toDateString(),
                'jumlah_pembayaran' => $jumlahBaru,
                'metode_pembayaran' => $validated['metode_pembayaran_baru'],
            ]);

            Log::info('Pembayaran detail berhasil dibuat.');

            $totalDibayar = $pembayaran->pembayaranDetail->sum('jumlah_pembayaran');
            $sisaPembayaran = max(0, $totalHarga - $totalDibayar);
            $status = $sisaPembayaran <= 0 ? 'Lunas' : 'Belum Lunas';

            $pembayaran->update([
                'tanggal_pembayaran' => now()->toDateString(),
                'total_pembayaran' => $totalHarga,
                'sisa_pembayaran' => $sisaPembayaran,
                'status_pembayaran' => $status,
            ]);
        }

        return redirect('/dashboard/reservasi')->with('edit_sukses', 1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->delete();
        
        return redirect()->back()->with('delete_sukses', 1);
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
}
