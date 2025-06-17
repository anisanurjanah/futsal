

<?php $__env->startSection('title', 'Lapangan'); ?>

<?php $__env->startSection('breadcrums'); ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Lapangan</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-6">
            <form action="<?php echo e(url('/dashboard/lapangan/' . $row->id)); ?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="<?php echo e(url('/dashboard/lapangan')); ?>" class="btn btn-default">
                                        <i class="fas fa fa-reply"></i> Kembali </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>NAMA lapangan</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        autocomplete="off" value="<?php echo e($row->name); ?>" required>
                                        <input type="hidden" name="id" value="<?php echo e($row->id); ?>">
                                </div>
                                <div class="form-group">
                                    <label>HARGA PER JAM</label>
                                    <input type="number" class="form-control" name="price" id="price"
                                        autocomplete="off" value="<?php echo e($row->price); ?>" required>
                                </div>
                            </div>


                        </div>

                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/lapangan/edit.blade.php ENDPATH**/ ?>