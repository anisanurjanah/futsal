

<?php $__env->startSection('title', 'Keuangan'); ?>

<?php $__env->startSection('breadcrums'); ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Keuangan</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            
        </div>
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="form-row row">
                    <div class="col-4">
                        <select name="filter" class="form-control">
                            <option value="hari" <?php echo e($filter == 'hari' ? 'selected' : ''); ?>>Hari Ini</option>
                            <option value="minggu" <?php echo e($filter == 'minggu' ? 'selected' : ''); ?>>Minggu Ini</option>
                            <option value="bulan" <?php echo e($filter == 'bulan' ? 'selected' : ''); ?>>Bulan Ini</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <input type="date" name="tanggal" class="form-control" value="<?php echo e($tanggal); ?>">
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                        <a href="<?php echo e(url('/dashboard/keuangan/export-pdf?filter=' . $filter)); ?>" class="btn btn-danger">Export PDF</a>
                    </div>
                </div>
            </form>

            <table class="table table-sm table-borderless mb-4">
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
                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>
                            <td><?php echo e($item->reservasi->pelanggan->name ?? '-'); ?></td>
                            <td><?php echo e($item->tanggal_pembayaran); ?></td>
                            <td>Rp <?php echo e(number_format($item->total_pembayaran, 0, ',', '.')); ?></td>
                            <td><span class="badge <?php echo e($item->status_pembayaran == 'Lunas' ? 'bg-success' : 'bg-warning'); ?>"><?php echo e($item->status_pembayaran); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/keuangan/index.blade.php ENDPATH**/ ?>