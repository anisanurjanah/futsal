

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
            <form action="<?php echo e(url('/dashboard/reservasi/' . $row->id)); ?>" method="post" id="reservasiForm">
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
                                <input type="hidden" name="pelanggan_id" value="<?php echo e($row->id_pelanggan); ?>">
                                <div class="form-group">
                                    <label>PELANGGAN</label>
                                    <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                                        <option value="">--Pilih Pelanggan--</option>
                                        <?php $__currentLoopData = $pelanggan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($dt->id); ?>"
                                                <?php echo e((int)$row->pelanggan_id === (int)$dt->id ? 'selected' : ''); ?>>
                                                <?php echo e($dt->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>LAPANGAN</label>
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
                                    <select name="waktu_mulai" id="waktu_mulai" class="form-control" required data-old="<?php echo e($row->waktu_mulai ?? ''); ?>">
                                        <option value="">Pilih Waktu Mulai</option>
                                        <?php for($i = 10; $i <= 21; $i++): ?>
                                            <?php
                                                $value = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00';
                                                $label = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                            ?>
                                            <option value="<?php echo e($value); ?>" <?php echo e($row->waktu_mulai == $value ? 'selected' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="waktu_selesai">Waktu Selesai</label>
                                    <select name="waktu_selesai" id="waktu_selesai" class="form-control" required data-old="<?php echo e($row->waktu_selesai ?? ''); ?>">
                                        <option value="">Pilih Waktu Selesai</option>
                                        <?php for($i = 10; $i <= 21; $i++): ?>
                                            <?php
                                                $value = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00';
                                                $label = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                            ?>
                                            <option value="<?php echo e($value); ?>" <?php echo e($row->waktu_selesai == $value ? 'selected' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="text" class="form-control" id="total" name="total"
                                        value="Rp <?php echo e(number_format($row->pembayaran->total_pembayaran ?? 0, 0, ',', '.')); ?>"
                                        readonly disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
                                    <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran"
                                        value="<?php echo e(number_format($row->pembayaran->pembayaranDetail->first()?->jumlah_pembayaran ?? 0, 0, ',', '.')); ?>">
                                </div>

                                

                                <div class="form-group">
                                    <label for="metode_pembayaran">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                        <option value="">-- Pilih Metode --</option>
                                        <?php $__currentLoopData = $metodePembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($metode); ?>" 
                                                <?php echo e($row->pembayaran->pembayaranDetail->first()?->metode_pembayaran == $metode ? 'selected' : ''); ?>>
                                                <?php echo e($metode); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($row->pembayaran->status_pembayaran === 'Belum Lunas'): ?>
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Tambah Pembayaran</h5>
                                        <div class="form-group mb-3">
                                            <label for="jumlah_pembayaran_baru">Jumlah Pembayaran Baru</label>
                                            <input type="text" class="form-control" id="jumlah_pembayaran_baru" name="jumlah_pembayaran_baru">
                                        </div>

                                        
                        
                                        <div class="form-group mb-3">
                                            <label for="metode_pembayaran_baru">Metode Pembayaran</label>
                                            <select name="metode_pembayaran_baru" id="metode_pembayaran_baru" class="form-control">
                                                <option value="">-- Pilih Metode --</option>
                                                <?php $__currentLoopData = $metodePembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($metode); ?>"><?php echo e($metode); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
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
            const tanggalInput = document.getElementById('tanggal');
            const jumlahPembayaranEl = document.getElementById('jumlah_pembayaran');
            const sisaPembayaranEl = document.getElementById('sisa_pembayaran');
            const jumlahPembayaranBaruEl = document.getElementById('jumlah_pembayaran_baru');
            const sisaPembayaranBaruEl = document.getElementById('sisa_pembayaran_baru');
            const hargaLapangan = <?php echo json_encode($lapangan, 15, 512) ?>;

            if (tanggalInput.value && document.getElementById('lapangan_id').value) {
                // fetchAvailableTimes();
            }

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

            // Fungsi untuk ambil jam yang tersedia via AJAX
            function fetchAvailableTimes() {
                const tanggal = tanggalInput.value;
                const lapanganId = document.getElementById('lapangan_id').value;

                if (!tanggal || !lapanganId) return;

                const waktuMulai = document.getElementById('waktu_mulai');
                const waktuSelesai = document.getElementById('waktu_selesai');

                const waktuMulaiOld = waktuMulai.dataset.old || '';
                const waktuSelesaiOld = waktuSelesai.dataset.old || '';

                fetch('<?php echo e(url("/cek-jadwal")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        tanggal: tanggal,
                        lapangan_id: lapanganId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    waktuMulai.innerHTML = '<option value="">Pilih Waktu Mulai</option>';
                    waktuSelesai.innerHTML = '<option value="">Pilih Waktu Selesai</option>';

                    data.forEach(jam => {
                        const option = document.createElement('option');
                        option.value = jam;
                        option.textContent = jam.substring(0, 5);
                        if (jam === waktuMulaiOld) option.selected = true;
                        waktuMulai.appendChild(option);
                    });

                    if (waktuMulaiOld) {
                        const selectedHour = parseInt(waktuMulaiOld.split(':')[0]);
                        for (let i = selectedHour + 1; i <= 21; i++) {
                            const jam = `${i.toString().padStart(2, '0')}:00:00`;
                            const option = document.createElement('option');
                            option.value = jam;
                            option.textContent = jam.substring(0, 5);
                            if (jam === waktuSelesaiOld) option.selected = true;
                            waktuSelesai.appendChild(option);
                        }
                    }
                })
                .catch(error => console.error('Gagal ambil jadwal:', error));
            }

            function hitungTotalHarga() {
                const lapanganId = document.getElementById('lapangan_id').value;
                const waktuMulaiEl = document.getElementById('waktu_mulai');
                const waktuSelesaiEl = document.getElementById('waktu_selesai');
                const totalEl = document.getElementById('total');
                const hargaDpEl = document.getElementById('harga_dp');
                const dpWrapper = document.getElementById('dp_wrapper');

                if (!lapanganId || !waktuMulaiEl.value || !waktuSelesaiEl.value) {
                    totalEl.value = 'Rp 0';
                    hargaDpEl.value = 'Rp 0';
                    dpWrapper.classList.add('d-none');
                    return;
                }

                const harga = hargaLapangan.find(l => l.id == lapanganId)?.price || 0;
                const durasi = parseInt(waktuSelesaiEl.value.split(':')[0]) - parseInt(waktuMulaiEl.value.split(':')[0]);
                const total = harga * durasi;

                totalEl.value = 'Rp ' + total.toLocaleString('id-ID');

                // Cek jika tipe pembayaran adalah DP
                const tipePembayaran = document.querySelector('input[name="tipe_pembayaran"]:checked')?.value;
                if (tipePembayaran === 'dp') {
                    hargaDpEl.value = 'Rp ' + (total / 2).toLocaleString('id-ID');
                    dpWrapper.classList.remove('d-none');
                } else {
                    dpWrapper.classList.add('d-none');
                    hargaDpEl.value = 'Rp 0';
                }
            }

            function updateSisaPembayaran() {
                const totalText = document.getElementById('total').value;
                const jumlahPembayaran = parseInt(jumlahPembayaranEl.value || 0);
                const jumlahPembayaranBaru = parseInt(jumlahPembayaranBaruEl.value || 0);

                const total = parseInt(totalText.replace(/[^\d]/g, '') || 0);

                const sisa = total - jumlahPembayaran;
                const sisaBaru = total - jumlahPembayaran - jumlahPembayaranBaruEl;
                
                sisaPembayaranEl.value = 'Rp ' + (sisa > 0 ? sisa : 0).toLocaleString('id-ID');
                sisaPembayaranBaruEl.value = 'Rp ' + (sisaBaru > 0 ? sisaBaru : 0).toLocaleString('id-ID');
            }

            document.getElementById('lapangan_id').addEventListener('change', fetchAvailableTimes);
            document.getElementById('tanggal').addEventListener('change', fetchAvailableTimes);

            // Event listener untuk waktu mulai
            // waktuMulai.addEventListener('change', function() {
            //     filterWaktuSelesai();
            // });

            // Event listener untuk waktu selesai
            waktuSelesai.addEventListener('change', validateTime);

            document.getElementById('waktu_mulai').addEventListener('change', hitungTotalHarga);
            document.getElementById('waktu_selesai').addEventListener('change', hitungTotalHarga);

            document.querySelectorAll('input[name="tipe_pembayaran"]').forEach(input => {
                input.addEventListener('change', hitungTotalHarga);
            });

            jumlahPembayaranEl.addEventListener('input', updateSisaPembayaran);
            jumlahPembayaranBaruEl.addEventListener('input', updateSisaPembayaran);

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