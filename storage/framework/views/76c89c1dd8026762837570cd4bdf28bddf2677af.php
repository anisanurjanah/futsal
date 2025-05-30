<?php $__env->startSection('title', 'Profil'); ?>

<?php $__env->startSection('breadcrums'); ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Profil</h1>
        </div>
        <div class="col-sm-6">

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php

        $data = DB::table('tbl_user')
            ->join('tbl_role', 'tbl_role.id', '=', 'tbl_user.id_role')
            ->select('tbl_user.*', 'tbl_role.nama_role')
            ->where('tbl_user.id', session()->get('id_user'))
            ->get();
    ?>

    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $nama_lengkap = $item->nama_lengkap;
            $email = $item->email;
            $nama_role = $item->nama_role;
        ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="row">
        <div class="col-md-3">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="rounded mx-auto d-block" src="<?php echo e(url('img/profil/kosong.jpg')); ?>" width="200"
                            height="200">
                    </div>
                    <h3 class="profile-username text-center"><?php echo e($nama_lengkap); ?></h3>
                    <p class="text-muted text-center"><?php echo e($email); ?></p>
                    <br><br>
                </div>

            </div>

        </div>

        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <strong><i class="fas fa-user mr-1"></i> Nama Lengkap</strong>
                    <p class="text-muted "><?php echo e($nama_lengkap); ?></p>
                    <hr>
                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted "><?php echo e($email); ?></p>
                    <hr>
                    <strong><i class="fas fa-group mr-1"></i> Level User</strong>
                    <p class="text-muted "><?php echo e($nama_role); ?></p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> Jenis Kelamin</strong>
                    <p class="text-muted ">
                        <?php if($item->id_gender == '1'): ?>
                            Laki - laki
                        <?php elseif($item->id_gender == '2'): ?>
                            Perempuan
                        <?php endif; ?>
                        </h5>
                    </p>
                    <hr>

                </div>

            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script>
        function add_sukses() {
            Swal.fire({
                icon: 'success',
                title: ' &nbsp; Tambah Data Berhasil'
            });
        }
    </script>

    <?php if(session('add_sukses')): ?>
        <script>
            add_sukses();
        </script>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/dashboard/profil.blade.php ENDPATH**/ ?>