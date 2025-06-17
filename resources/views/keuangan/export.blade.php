<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; }

        .reservasi-summary {
            width: 100%;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .reservasi-summary th,
        .reservasi-summary td {
            border: none;
            padding:8px;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 6px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Laporan Keuangan</h2>

    <table class="reservasi-summary">
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

    <table>
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
            @foreach ($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->reservasi->pelanggan->name ?? '-' }}</td>
                    <td>{{ $item->tanggal_pembayaran }}</td>
                    <td>Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}</td>
                    <td>{{ $item->status_pembayaran }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
