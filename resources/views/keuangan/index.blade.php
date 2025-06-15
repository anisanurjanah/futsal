@extends('layout.main')

@section('title', 'Keuangan')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Keuangan</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            {{-- <a href="{{ url('/dashboard/keuangan/export-pdf?filter=' . $filter) }}" class="btn btn-danger btn-sm">Export PDF</a> --}}
        </div>
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="form-row row">
                    <div class="col-4">
                        <select name="filter" class="form-control">
                            <option value="hari" {{ $filter == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="minggu" {{ $filter == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="bulan" {{ $filter == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                        <a href="{{ url('/dashboard/keuangan/export-pdf?filter=' . $filter) }}" class="btn btn-danger">Export PDF</a>
                    </div>
                </div>
            </form>

            <table class="table table-sm table-borderless mb-4">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 30%">Filter</th>
                        <td style="width: 8px">:</td>
                        <td>
                            @if ($filter == 'hari')
                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                            @elseif ($filter == 'minggu')
                                {{ \Carbon\Carbon::now()->startOfWeek()->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::now()->endOfWeek()->translatedFormat('d F Y') }}
                            @elseif ($filter == 'bulan')
                                {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Total Pendapatan</th>
                        <td>:</td>
                        <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Jumlah Transaksi</th>
                        <td>:</td>
                        <td>{{ $jumlahTransaksi }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reservasi</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->reservasi->pelanggan->name ?? '-' }}</td>
                            <td>{{ $item->tanggal_pembayaran }}</td>
                            <td>Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $item->status_pembayaran == 'Lunas' ? 'bg-success' : 'bg-warning' }}">{{ $item->status_pembayaran }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
