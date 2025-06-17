<?php $__env->startSection('title', 'User'); ?>

<?php $__env->startSection('breadcrums'); ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>User</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="ml-auto">
                                <h5>Edit Data</h5>
                            </div>
                        </div>
                        <div class="col mr-auto">
                            <div class="mr-auto float-right">
                                <a href="<?php echo e(url('/dashboard/pengguna')); ?>" class="btn btn-default">
                                    << Go Back to List </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(url('/dashboard/pengguna/' . $row->id)); ?>" method="post">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="hidden" name="id" value="<?php echo e($row->id); ?>">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="<?php echo e($row->name); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="<?php echo e($row->email); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        value="<?php echo e($row->password); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>User Grup</label>
                                    <select name="role" id="role" class="form-control" required>
                                        <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>" <?php echo e(strtolower($row->role) == strtolower($key) ? 'selected' : ''); ?>>
                                                <?php echo e($value); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/pengguna/edit.blade.php ENDPATH**/ ?>