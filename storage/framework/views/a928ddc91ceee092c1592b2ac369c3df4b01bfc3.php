

<?php $__env->startSection('title', 'Booking'); ?>

<?php $__env->startSection('breadcrums'); ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Booking</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <a href="<?php echo e(url('/dashboard/reservasi')); ?>" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Pelanggan</th>
                    <td><?php echo e($row->pelanggan->name); ?></td>
                </tr>
                <tr>
                    <th>Nama Lapangan</th>
                    <td><?php echo e($row->lapangan->name); ?></td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td><?php echo e($row->tanggal); ?></td>
                </tr>
                <tr>
                    <th>Jam Mulai</th>
                    <td><?php echo e($row->waktu_mulai); ?></td>
                </tr>
                <tr>
                    <th>Jam Selesai</th>
                    <td><?php echo e($row->waktu_selesai); ?></td>
                </tr>
                <tr>
                    <th>Harga per Jam</th>
                    <td>Rp <?php echo e(number_format($row->lapangan->price, 0, ',', '.')); ?></td>
                </tr>
                <tr>
                    <th>Durasi</th>
                    <td>
                        <?php
                            $start = new \DateTime($row->waktu_mulai);
                            $end = new \DateTime($row->waktu_selesai);
                            $durasi = $start->diff($end)->format('%h');
                        ?>
                        <?php echo e($durasi); ?> jam
                    </td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp <?php echo e(number_format($durasi * $row->lapangan->price, 0, ',', '.')); ?></td>
                </tr>
            </table>

            <hr>

            <h5>Informasi Pembayaran</h5>
            <?php if(!$row->pembayaran): ?>
                <p class="text-center">Tidak ada data pembayaran yang ditampilkan.</p>
            <?php else: ?>
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal Pembayaran</th>
                        <td><?php echo e($row->pembayaran->tanggal_pembayaran); ?></td>
                    </tr>
                    <tr>
                        <th>Total Pembayaran</th>
                        <td>Rp <?php echo e(number_format($row->pembayaran->total_pembayaran, 0, ',', '.')); ?></td>
                    </tr>
                    <tr>
                        <th>Sisa Pembayaran</th>
                        <td>Rp <?php echo e(number_format($row->pembayaran->sisa_pembayaran, 0, ',', '.')); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge <?php echo e($row->pembayaran->status_pembayaran == 'Lunas' ? 'bg-success' : 'bg-warning'); ?>">
                                <?php echo e($row->pembayaran->status_pembayaran); ?>

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
                        <?php $__currentLoopData = $row->pembayaran->pembayaranDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><?php echo e($detail->tanggal_pembayaran); ?></td>
                                <td>Rp <?php echo e(number_format($detail->jumlah_pembayaran, 0, ',', '.')); ?></td>
                                <td><?php echo e($detail->metode_pembayaran); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/booking/show.blade.php ENDPATH**/ ?>