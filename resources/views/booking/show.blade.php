@extends('layout.main')

@section('title', 'Booking')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Booking</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ url('/dashboard/reservasi') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Pelanggan</th>
                    <td>{{ $row->pelanggan->name }}</td>
                </tr>
                <tr>
                    <th>Nama Lapangan</th>
                    <td>{{ $row->lapangan->name }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $row->tanggal }}</td>
                </tr>
                <tr>
                    <th>Jam Mulai</th>
                    <td>{{ $row->waktu_mulai }}</td>
                </tr>
                <tr>
                    <th>Jam Selesai</th>
                    <td>{{ $row->waktu_selesai }}</td>
                </tr>
                <tr>
                    <th>Harga per Jam</th>
                    <td>Rp {{ number_format($row->lapangan->price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Durasi</th>
                    <td>
                        @php
                            $start = new \DateTime($row->waktu_mulai);
                            $end = new \DateTime($row->waktu_selesai);
                            $durasi = $start->diff($end)->format('%h');
                        @endphp
                        {{ $durasi }} jam
                    </td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp {{ number_format($durasi * $row->lapangan->price, 0, ',', '.') }}</td>
                </tr>
            </table>

            <hr>

            <h5>Informasi Pembayaran</h5>
            @if (!$row->pembayaran)
                <p class="text-center">Tidak ada data pembayaran yang ditampilkan.</p>
            @else
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal Pembayaran</th>
                        <td>{{ $row->pembayaran->tanggal_pembayaran }}</td>
                    </tr>
                    <tr>
                        <th>Total Pembayaran</th>
                        <td>Rp {{ number_format($row->pembayaran->total_pembayaran, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Sisa Pembayaran</th>
                        <td>Rp {{ number_format($row->pembayaran->sisa_pembayaran, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge {{ $row->pembayaran->status_pembayaran == 'Lunas' ? 'bg-success' : 'bg-warning' }}">
                                {{ $row->pembayaran->status_pembayaran }}
                            </span>
                        </td>
                    </tr>
                </table>

                <h6 class="mt-4">Rincian Pembayaran</h6>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($row->pembayaran->pembayaranDetail as $i => $detail)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $detail->tanggal_pembayaran }}</td>
                                <td>Rp {{ number_format($detail->jumlah_pembayaran, 0, ',', '.') }}</td>
                                <td>{{ $detail->metode_pembayaran }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
