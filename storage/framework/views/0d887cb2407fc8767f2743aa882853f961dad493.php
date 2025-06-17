

<?php $__env->startSection('title', 'Pelanggan'); ?>

<?php $__env->startSection('breadcrums'); ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Pelanggan</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-6">
            <form action="<?php echo e(url('/dashboard/pelanggan/' . $row->id)); ?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="<?php echo e(url('/dashboard/pelanggan')); ?>" class="btn btn-default">
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
                                    <label>NAMA</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        autocomplete="off" value="<?php echo e($row->name); ?>" required>
                                    <input type="hidden" name="id" value="<?php echo e($row->id); ?>">
                                </div>
                                <div class="form-group">
                                    <label>EMAIL</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        autocomplete="off" value="<?php echo e($row->email); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>NO TELEPON</label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        autocomplete="off" value="<?php echo e($row->phone); ?>" required>
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

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/member/edit.blade.php ENDPATH**/ ?>