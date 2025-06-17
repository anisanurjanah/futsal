

<?php $__env->startSection('title', 'Pembayaran'); ?>

<?php $__env->startSection('content'); ?>

    <div class="text-center mt-5">
        <div class="mb-4">
            <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
        </div>

        <h3 class="fw-semibold">Memproses Pembayaran...</h3>
        <p class="text-muted">Jangan tutup atau refresh halaman ini.</p>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(env('MIDTRANS_CLIENT_KEY')); ?>"></script>
    <script type="text/javascript">
        window.onload = function () {
            snap.pay("<?php echo e($snapToken); ?>", {
                onSuccess: function(result){
                    window.location.href = "/reservasi/<?php echo e(Illuminate\Support\Str::lower($reservasi->order_id)); ?>";
                },
                onPending: function(result){
                    console.log("pending", result);
                },
                onError: function(result){
                    alert("Pembayaran gagal");
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/home/payment.blade.php ENDPATH**/ ?>