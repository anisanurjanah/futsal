@extends('layout.home')

@section('title', 'Detail Reservasi')

@section('content')

    <div class="container text-center mt-5">
        <h2 class="text-success">Pembayaran Berhasil!</h2>
        <p>Terima kasih, reservasi Anda telah dikonfirmasi.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
    </div>

@endsection
