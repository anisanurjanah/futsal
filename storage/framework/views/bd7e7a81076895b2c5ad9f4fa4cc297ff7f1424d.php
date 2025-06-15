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
            <a href="<?php echo e(url('/dashboard/reservasi/create')); ?>" class="btn btn-primary"> <i class="fas fa-plus"></i> Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="tabelbooking" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th class="text-center">NAMA PELANGGAN</th>
                        <th class="text-center">LAPANGAN</th>
                        <th class="text-center">TANGGAL</th>
                        <th class="text-center">DURASI</th>
                        <th class="text-center">TOTAL HARGA</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">PEMBAYARAN</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($item['nama']); ?></td>
                            <td><?php echo e($item['nama_lapangan']); ?></td>
                            <td><?php echo e($item['tanggal']); ?></td>
                            <td class="text-center"><?php echo e($item['durasi']); ?> jam</td>
                            <td class="text-right">Rp.
                                <?php echo e(number_format($item['durasi'] * $item['harga'], 0, ',', '.')); ?></td>
                            <td><?php echo e($item['status']); ?></td>
                            <td class="text-center">
                                <?php if($item['status_pembayaran'] == 'Belum Lunas'): ?>
                                    <span class="badge bg-primary"><?php echo e($item['status_pembayaran']); ?></span>
                                <?php elseif($item['status_pembayaran'] == 'Lunas'): ?>
                                    <span class="badge bg-success"><?php echo e($item['status_pembayaran']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(url('/dashboard/reservasi/' . $item['id'])); ?>" class="btn btn-xs btn-primary"
                                    title="Show"><i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(url('/dashboard/reservasi/' . $item['id']) . '/edit'); ?>" class="btn btn-xs btn-warning"
                                    title="Edit"><i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-form-<?php echo e($item['id']); ?>" action="<?php echo e(url('/dashboard/reservasi/' . $item['id'])); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                                <button onclick="del(<?php echo e($item['id']); ?>)" class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script>
        $('#tabelbooking').bookingTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            scrollX: true,
        });

        function add_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });

            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Tambah Data Berhasil'
            });
        }

        function edit_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });

            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Update Data Berhasil'
            });
        }

        function delete_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });

            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Hapus Data Berhasil'
            });
        }

        function del(id) {
            Swal.fire({
                title: "Ingin Menghapus Data ini?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    <?php if(session('add_sukses')): ?>
        <script>
            add_sukses();
        </script>
    <?php endif; ?>

    <?php if(session('edit_sukses')): ?>
        <script>
            edit_sukses();
        </script>
    <?php endif; ?>

    <?php if(session('delete_sukses')): ?>
        <script>
            delete_sukses();
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/booking/index.blade.php ENDPATH**/ ?>