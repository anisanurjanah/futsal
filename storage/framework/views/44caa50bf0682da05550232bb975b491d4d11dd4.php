

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reservasi Lapangan</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('reservasi/add')); ?>" method="POST" id="reservasiForm">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id_user" value="<?php echo e(session()->get('id_user')); ?>">
                            <div class="form-group mb-3">
                                <label class="d-block">Tipe Lapangan</label>
                                <div class="d-flex gap-3">
                                    <?php $__currentLoopData = $tipeLapangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipe_lapangan"
                                                id="lapangan<?php echo e($item->id); ?>" value="<?php echo e($item->id); ?>"
                                                data-harga="<?php echo e($item->hargaperjam); ?>" required>
                                            <label class="form-check-label" for="lapangan<?php echo e($item->id); ?>">
                                                <?php echo e($item->namalapangan); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="nomor_telepon">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="waktu_mulai">Waktu Mulai</label>
                                <select name="waktu_mulai" id="waktu_mulai" class="form-control" required>
                                    <option value="">Pilih Waktu Mulai</option>
                                    <?php for($i = 1; $i <= 24; $i++): ?>
                                        <?php if($i < 10): ?>
                                            <option value="0<?php echo e($i); ?>:00:00">0<?php echo e($i); ?>:00</option>
                                        <?php else: ?>
                                            <option value="<?php echo e($i); ?>:00:00"><?php echo e($i); ?>:00</option>
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
                                            <option value="0<?php echo e($i); ?>:00:00">0<?php echo e($i); ?>:00</option>
                                        <?php else: ?>
                                            <option value="<?php echo e($i); ?>:00:00"><?php echo e($i); ?>:00</option>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Buat Reservasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

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

                // Reset waktu selesai
                waktuSelesai.value = '';

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
        <?php if(session('add_gagal')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jadwal sudah ada',
            });
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/home/reservasi.blade.php ENDPATH**/ ?>