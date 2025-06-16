

<?php $__env->startSection('title', 'Booking'); ?>

<?php $__env->startSection('breadcrums'); ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Data</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md">
            <form action="<?php echo e(url('/dashboard/reservasi')); ?>" method="post" id="bookingForm">
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
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Pelanggan</label>
                                    <select name="pelanggan_id" id="pelanggan_id" class="form-control select2" required>
                                        <option value="">--Pilih Pelanggan--</option>
                                        <?php $__currentLoopData = $pelanggan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($dt->id); ?>"><?php echo e($dt->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Lapangan</label>
                                    <select name="lapangan_id" id="lapangan_id" class="form-control" required>
                                        <option value="">--Pilih Lapangan--</option>
                                        <?php $__currentLoopData = $lapangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($dt->id); ?>"><?php echo e($dt->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required
                                        min="<?php echo e(date('Y-m-d')); ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="waktu_mulai">Waktu Mulai</label>
                                    <select name="waktu_mulai" id="waktu_mulai" class="form-control" required>
                                        <option value="">Pilih Waktu Mulai</option>
                                        <?php for($i = 10; $i <= 20; $i++): ?>
                                            <option value="<?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?>:00:00">
                                                <?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?>:00
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="waktu_selesai">Waktu Selesai</label>
                                    <select name="waktu_selesai" id="waktu_selesai" class="form-control" required>
                                        <option value="">Pilih Waktu Selesai</option>
                                        <?php for($i = 11; $i <= 21; $i++): ?>
                                            <option value="<?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?>:00:00">
                                                <?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?>:00
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="d-block">Pembayaran</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipe_pembayaran"
                                            id="tipe_dp" value="dp" required>
                                        <label class="form-check-label" for="tipe_dp">
                                            Down Payment
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipe_pembayaran"
                                            id="tipe_lunas" value="lunas" required>
                                        <label class="form-check-label" for="tipe_lunas">
                                            Lunas
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="text" class="form-control" id="total" name="total" value="Rp 0" readonly disabled>
                                </div>
                                <div class="form-group d-none" id="dp_wrapper">
                                    <label for="harga_dp">Harga DP (50%)</label>
                                    <input type="text" class="form-control" id="harga_dp" value="Rp 0" readonly disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
                                    <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="sisa_pembayaran">Sisa Pembayaran</label>
                                    <input type="text" class="form-control" id="sisa_pembayaran" name="sisa_pembayaran" disabled>
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
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bookingForm');
            const waktuMulai = document.getElementById('waktu_mulai');
            const waktuSelesai = document.getElementById('waktu_selesai');
            const waktuError = document.getElementById('waktuError');
            const tanggalInput = document.getElementById('tanggal');
            const jumlahPembayaranEl = document.getElementById('jumlah_pembayaran');
            const sisaPembayaranEl = document.getElementById('sisa_pembayaran');
            const hargaLapangan = <?php echo json_encode($lapangan, 15, 512) ?>;

            if (tanggalInput.value && document.getElementById('lapangan_id').value) {
                fetchAvailableTimes();
            }

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

            // Fungsi untuk ambil jam yang tersedia via AJAX
            function fetchAvailableTimes() {
                const tanggal = tanggalInput.value;
                const lapanganId = document.getElementById('lapangan_id').value

                if (!tanggal || !lapanganId) return;
                
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
                    console.log('Available times:', data);

                    waktuMulai.innerHTML = '<option value="">Pilih Waktu Mulai</option>';
                    waktuSelesai.innerHTML = '<option value="">Pilih Waktu Selesai</option>';

                    data.forEach(jam => {
                        const option = document.createElement('option');
                        option.value = jam;
                        option.textContent = jam.substring(0, 5);
                        waktuMulai.appendChild(option);
                    });

                    waktuMulai.addEventListener('change', function() {
                        const selectedHour = parseInt(this.value.split(':')[0]);
                        waktuSelesai.innerHTML = '<option value="">Pilih Waktu Selesai</option>';

                        for (let i = selectedHour + 1; i <= 21; i++) {
                            const jam = `${i.toString().padStart(2, '0')}:00:00`;
                            const option = document.createElement('option');
                            option.value = jam;
                            option.textContent = jam.substring(0, 5);
                            waktuSelesai.appendChild(option);
                        }
                    })
                })
                .catch(error => {
                    console.error('Gagal ambil jadwal:', error);
                });
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

                const total = parseInt(totalText.replace(/[^\d]/g, '') || 0);

                const sisa = total - jumlahPembayaran;
                sisaPembayaranEl.value = 'Rp ' + (sisa > 0 ? sisa : 0).toLocaleString('id-ID');
            }

            document.getElementById('lapangan_id').addEventListener('change', fetchAvailableTimes);
            document.getElementById('tanggal').addEventListener('change', fetchAvailableTimes);

            // Event listener untuk waktu mulai
            // waktuMulai.addEventListener('change', function() {
            //     filterWaktuSelesai();
            //     hitungTotalHarga();
            // });

            // Event listener untuk waktu selesai
            waktuSelesai.addEventListener('change', validateTime);

            document.getElementById('waktu_mulai').addEventListener('change', hitungTotalHarga);
            document.getElementById('waktu_selesai').addEventListener('change', hitungTotalHarga);

            document.querySelectorAll('input[name="tipe_pembayaran"]').forEach(input => {
                input.addEventListener('change', hitungTotalHarga);
            });

            jumlahPembayaranEl.addEventListener('input', updateSisaPembayaran);

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

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/booking/add.blade.php ENDPATH**/ ?>