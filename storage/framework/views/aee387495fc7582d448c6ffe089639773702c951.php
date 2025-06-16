

<?php $__env->startSection('title', 'Booking'); ?>

<?php $__env->startSection('breadcrums'); ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Booking</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md">
            <form action="<?php echo e(url('/dashboard/reservasi/' . $row->id)); ?>" method="POST" id="reservasiForm">
                <?php echo method_field('PUT'); ?>
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="<?php echo e(url('/dashboard/reservasi')); ?>" class="btn btn-default">
                                        <i class="fas fa fa-reply"></i> Kembali </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?php echo e($row->id); ?>">
                                <input type="hidden" name="idmember" value="<?php echo e($row->id_pelanggan); ?>">
                                <div class="form-group">
                                    <label>NAMA LAPANGAN</label>
                                    <select name="lapangan_id" id="lapangan_id" class="form-control" required>
                                        <option value="">--Pilih Lapangan--</option>
                                        <?php $__currentLoopData = $lapangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($dt->id); ?>"
                                                <?php echo e((int)$row->lapangan_id === (int)$dt->id ? 'selected' : ''); ?>>
                                                <?php echo e($dt->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        value="<?php echo e($row->tanggal); ?>" required min="<?php echo e(date('Y-m-d')); ?>">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="waktu_mulai">Waktu Mulai</label>
                                    <select name="waktu_mulai" id="waktu_mulai" class="form-control" required>
                                        <option value="">Pilih Waktu Mulai</option>
                                        <?php for($i = 1; $i <= 24; $i++): ?>
                                            <?php if($i < 10): ?>
                                                <?php if($row->waktu_mulai == '0' . $i . ':00:00'): ?>
                                                    <option value="0<?php echo e($i); ?>:00:00" selected>
                                                        <?php echo e($i); ?>:00
                                                    </option>
                                                <?php else: ?>
                                                    <option value="0<?php echo e($i); ?>:00:00">
                                                        <?php echo e($i); ?>:00
                                                    </option>.
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if($row->waktu_mulai == $i . ':00:00'): ?>
                                                    <option value="<?php echo e($i); ?>:00:00" selected>
                                                        <?php echo e($i); ?>:00
                                                    </option>
                                                <?php else: ?>
                                                    <option value="<?php echo e($i); ?>:00:00">
                                                        <?php echo e($i); ?>:00
                                                    </option>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="waktu_selesai">Waktu Selesai</label>
                                    <select name="waktu_selesai" id="waktu_selesai" class="form-control" required>
                                        <option value="">Pilih Waktu Selesai</option>
                                        <?php for($i = 1; $i <= 24; $i++): ?>
                                            <?php if($i < 10): ?>
                                                <?php if($row->waktu_selesai == '0' . $i . ':00:00'): ?>
                                                    <option value="0<?php echo e($i); ?>:00:00" selected>
                                                        <?php echo e($i); ?>:00
                                                    </option>
                                                <?php else: ?>
                                                    <option value="0<?php echo e($i); ?>:00:00">
                                                        <?php echo e($i); ?>:00
                                                    </option>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if($row->waktu_selesai == $i . ':00:00'): ?>
                                                    <option value="<?php echo e($i); ?>:00:00" selected>
                                                        <?php echo e($i); ?>:00
                                                    </option>
                                                <?php else: ?>
                                                    <option value="<?php echo e($i); ?>:00:00">
                                                        <?php echo e($i); ?>:00
                                                    </option>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                    <?php if($row->pembayaran->status_pembayaran === 'Belum Lunas'): ?>
                        <hr>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Tambah Pembayaran</h5>
                                    <form action="<?php echo e(url('/dashboard/pembayarandetails')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="reservasi_id" value="<?php echo e($row->id); ?>">
            
                                        <div class="form-group">
                                            <label for="jumlah_pembayaran">Jumlah Pembayaran (Rp)</label>
                                            <input type="number" name="jumlah_pembayaran" id="jumlah_pembayaran" class="form-control" min="1000" required>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="metode_pembayaran">Metode Pembayaran</label>
                                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                                <option value="">-- Pilih Metode --</option>
                                                <?php $__currentLoopData = $metodePembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($metode); ?>" <?php echo e(old('metode_pembayaran') == $metode ? 'selected' : ''); ?>>
                                                        <?php echo e($metode); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-success mt-2">Tambah Pembayaran</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php if(session('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?php echo e(session("success")); ?>',
        });
    </script>
<?php endif; ?>

<?php $__env->startSection('script'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reservasiForm');
            const waktuMulai = document.getElementById('waktu_mulai');
            const waktuSelesai = document.getElementById('waktu_selesai');
            const waktuError = document.getElementById('waktuError');

            // Fungsi untuk memfilter opsi waktu selesai
            function filterWaktuSelesai() {
                const selectedStartTime = parseFloat(waktuMulai.value);


                // Filter opsi waktu selesai
                Array.from(waktuSelesai.options).forEach(option => {
                    if (option.value === '') return; // Skip opsi default

                    const optionTime = parseFloat(option.value);
                    if (optionTime <= selectedStartTime) {
                        option.disabled = true;
                        option.style.display = 'none';
                    } else {
                        option.disabled = false;
                        option.style.display = '';
                    }
                });

                // Validasi waktu
                validateTime();
            }

            filterWaktuSelesai();

            function validateTime() {
                const startTime = waktuMulai.value;
                const endTime = waktuSelesai.value;

                if (startTime && endTime) {
                    if (parseFloat(endTime) <= parseFloat(startTime)) {
                        waktuSelesai.setCustomValidity('Waktu selesai harus lebih besar dari waktu mulai');
                        waktuSelesai.classList.add('is-invalid');
                        return false;
                    } else {
                        waktuSelesai.setCustomValidity('');
                        waktuSelesai.classList.remove('is-invalid');
                        return true;
                    }
                }
                return true;
            }

            // Event listener untuk waktu mulai
            waktuMulai.addEventListener('change', function() {
                filterWaktuSelesai();
            });

            // Event listener untuk waktu selesai
            waktuSelesai.addEventListener('change', validateTime);

            // Event listener untuk form submission
            form.addEventListener('submit', function(e) {
                if (!validateTime()) {
                    e.preventDefault();
                }
            });
        });
    </script>
    <script>
        <?php if(session('edit_gagal')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jadwal sudah ada',
            });
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/booking/edit.blade.php ENDPATH**/ ?>