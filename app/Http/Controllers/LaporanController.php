<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function keuangan(Request $request)
    {
        $filter = $request->query('filter', 'hari');
        $tanggal = $request->query('tanggal', now()->format('Y-m-d'));

        $parsedTanggal = \Carbon\Carbon::parse($tanggal);
        $query = Pembayaran::with('reservasi');

        if ($filter === 'hari') {
            $query->whereDate('tanggal_pembayaran', $parsedTanggal->toDateString());
        } elseif ($filter === 'minggu') {
            $query->whereBetween('tanggal_pembayaran', [
                $parsedTanggal->startOfWeek(),
                $parsedTanggal->endOfWeek(),
            ]);
        } elseif ($filter === 'bulan') {
            $query->whereMonth('tanggal_pembayaran', $parsedTanggal->month)
                ->whereYear('tanggal_pembayaran', $parsedTanggal->year);
        }

        $data = $query->latest()->get();
        $totalPendapatan = $query->sum('total_pembayaran');
        $jumlahTransaksi = $query->count();

        return view('keuangan.index', compact('data', 'tanggal', 'totalPendapatan', 'jumlahTransaksi', 'filter'));
    }

    public function exportPDF(Request $request)
    {
        $filter = $request->query('filter', 'hari');
        $query = Pembayaran::with('reservasi.pelanggan');

        if ($filter === 'hari') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($filter === 'minggu') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter === 'bulan') {
            $query->whereMonth('created_at', now()->month);
        }

        $data = $query->latest()->get();
        $totalPendapatan = $query->sum('total_pembayaran');
        $jumlahTransaksi = $query->count();

        $pdf = PDF::loadView('keuangan.export', compact('data', 'totalPendapatan', 'jumlahTransaksi', 'filter'));
        return $pdf->stream('laporan_keuangan.pdf');
    }
}
