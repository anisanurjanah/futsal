

<?php $__env->startSection('title', 'Detail Reservasi'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container text-center mt-5">
        <h2 class="text-success">Pembayaran Berhasil!</h2>
        <p>Terima kasih, reservasi Anda telah dikonfirmasi.</p>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Kembali ke Beranda</a>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/home/detail_reservasi.blade.php ENDPATH**/ ?>