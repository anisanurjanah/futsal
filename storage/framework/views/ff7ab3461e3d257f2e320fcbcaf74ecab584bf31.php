<?php $__env->startSection('title', 'Lapangan'); ?>

<?php $__env->startSection('breadcrums'); ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Lapangan</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <a href="<?php echo e(url('/dashboard/lapangan/create')); ?>" class="btn btn-primary"> <i class="fas fa-plus"></i> Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="tabellapangan" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th>NAMA LAPANGAN</th>
                        <th class="text-center">HARGA PER JAM</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($item->name); ?></td>  
                            <td class="text-right">Rp. <?php echo e(number_format($item->price,0,',','.')); ?></td>                             
                            <td class="text-center">
                                <a href="<?php echo e(url('/dashboard/lapangan/' . $item->id . '/edit')); ?>" class="btn btn-xs btn-warning"
                                    title="Edit"><i class="fas fa-edit"></i>
                                </a>
                                
                                <form id="delete-form-<?php echo e($item->id); ?>" action="<?php echo e(url('/dashboard/lapangan/' . $item->id)); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                                <button onclick="del(<?php echo e($item->id); ?>)" class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
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
        $('#tabellapangan').lapanganTable({
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

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/lapangan/index.blade.php ENDPATH**/ ?>