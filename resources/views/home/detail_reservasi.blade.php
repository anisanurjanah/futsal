@extends('layout.home')

@section('title', 'Detail Reservasi')

@section('content')

    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2 class="text-success"><i class="bi bi-check-circle-fill"></i> Pembayaran Berhasil!</h2>
            <p>Terima kasih, reservasi Anda telah dikonfirmasi.</p>
        </div>

        <h5 class="mb-4">Detail Reservasi</h5>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="row">Nama</th>
                    <td>{{ $reservasi->pelanggan->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td>{{ $reservasi->pelanggan->email }}</td>
                </tr>
                <tr>
                    <th scope="row">Nomor Telepon</th>
                    <td>{{ $reservasi->pelanggan->phone }}</td>
                </tr>
                <tr>
                    <th scope="row">Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <th scope="row">Lapangan</th>
                    <td>{{ $reservasi->lapangan->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Waktu</th>
                    <td>{{ \Carbon\Carbon::parse($reservasi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservasi->waktu_selesai)->format('H:i') }}</td>
                </tr>
                <tr>
                    <th scope="row">Total Pembayaran</th>
                    <td>Rp {{ number_format($reservasi->pembayaran->pembayaranDetail->first()?->jumlah_pembayaran, 0, ',', '.') }}</td>
                </tr>
                {{-- <tr>
                    <th scope="row">Metode Pembayaran</th>
                    <td>{{ strtoupper($reservasi->tipe_pembayaran) }}</td>
                </tr> --}}
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="bi bi-house-door-fill"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

@endsection
