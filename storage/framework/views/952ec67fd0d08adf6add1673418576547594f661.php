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
                    <?php if($filter == 'hari'): ?>
                        <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?>

                    <?php elseif($filter == 'minggu'): ?>
                        <?php echo e(\Carbon\Carbon::now()->startOfWeek()->translatedFormat('d F Y')); ?> - <?php echo e(\Carbon\Carbon::now()->endOfWeek()->translatedFormat('d F Y')); ?>

                    <?php elseif($filter == 'bulan'): ?>
                        <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Total Pendapatan</th>
                <td>:</td>
                <td>Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></td>
            </tr>
            <tr>
                <th scope="row">Jumlah Transaksi</th>
                <td>:</td>
                <td><?php echo e($jumlahTransaksi); ?></td>
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
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i + 1); ?></td>
                    <td><?php echo e($item->reservasi->pelanggan->name ?? '-'); ?></td>
                    <td><?php echo e($item->tanggal_pembayaran); ?></td>
                    <td>Rp <?php echo e(number_format($item->total_pembayaran, 0, ',', '.')); ?></td>
                    <td><?php echo e($item->status_pembayaran); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\futsal\resources\views/keuangan/export.blade.php ENDPATH**/ ?>