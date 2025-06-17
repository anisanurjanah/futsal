

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
        <div class="col-12">
            <form action="<?php echo e(url('/dashboard/reservasi/' . $row->id)); ?>" method="post" id="reservasiForm">
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
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-5">
                            <div class="col-md-6 px-4">
                                <input type="hidden" name="id" value="<?php echo e($row->id); ?>">
                                <input type="hidden" name="status" value="Ditunda">
                                <input type="hidden" id="waktuMulaiLama" value="<?php echo e($row->waktu_mulai); ?>">
                                <input type="hidden" id="waktuSelesaiLama" value="<?php echo e($row->waktu_selesai); ?>">

                                <div class="form-group">
                                    <label>PELANGGAN</label>
                                    <select name="pelanggan_id" id="pelanggan_id" class="form-control select2" required>
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
                                    <select name="waktu_mulai" id="waktu_mulai" class="form-control" required>
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
                                    <select name="waktu_selesai" id="waktu_selesai" class="form-control" required>
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
                            </div>

                            <div class="col-md-6 px-4">
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="text" class="form-control" id="total" name="total"
                                        value="Rp <?php echo e(number_format($row->pembayaran->total_pembayaran ?? 0, 0, ',', '.')); ?>"
                                        readonly disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
                                    <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran"
                                        value="<?php echo e($row->pembayaran->pembayaranDetail->first()?->jumlah_pembayaran); ?>">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sisa_pembayaran">Sisa Pembayaran</label>
                                    <input type="text" class="form-control" id="sisa_pembayaran" name="sisa_pembayaran"
                                        value="Rp <?php echo e(number_format($row->pembayaran->sisa_pembayaran ?? 0, 0, ',', '.')); ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <?php if($row->pembayaran->status_pembayaran === 'Belum Lunas'): ?>
                            <div class="row mt-4">
                                <div class="col-md-12 px-4">
                                    <h5 class="mb-3">Tambah Pembayaran</h5>
                                    <div class="form-group mb-3">
                                        <label for="jumlah_pembayaran_baru">Jumlah Pembayaran Baru</label>
                                        <input type="text" class="form-control" id="jumlah_pembayaran_baru" name="jumlah_pembayaran_baru" required>
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="metode_pembayaran_baru">Metode Pembayaran</label>
                                        <select name="metode_pembayaran_baru" id="metode_pembayaran_baru" class="form-control" required>
                                            <option value="">-- Pilih Metode --</option>
                                            <?php $__currentLoopData = $metodePembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($metode); ?>" <?php echo e(old('metode_pembayaran_baru') == $metode ? 'selected' : ''); ?>>
                                                    <?php echo e($metode); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-end p-3">
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
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

            // Setelah semua element diambil
            if (tanggalInput.value && document.getElementById('lapangan_id').value) {
                fetchAvailableTimes();
            }

            document.getElementById('lapangan_id').addEventListener('change', fetchAvailableTimes);
            tanggalInput.addEventListener('change', function() {
                fetchAvailableTimes();
            });

            // Event listener untuk waktu mulai
            waktuMulai.addEventListener('change', hitungTotalHarga);
            waktuSelesai.addEventListener('change', function() {
                validateTime();
                hitungTotalHarga();
            });

            document.querySelectorAll('input[name="tipe_pembayaran"]').forEach(input => {
                input.addEventListener('change', hitungTotalHarga);
            });

            jumlahPembayaranEl.addEventListener('input', updateSisaPembayaran);
            
            if (jumlahPembayaranBaruEl) {
                    jumlahPembayaranBaruEl.addEventListener('input', updateSisaPembayaran);
                }

            $('#pelanggan_id').select2({
                width: '100%'
            });
            
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

            function generateWaktuSelesai(selectedHour) {
                waktuSelesai.innerHTML = '<option value="">Pilih Waktu Selesai</option>';

                for (let i = selectedHour + 1; i <= 20; i++) {
                    const jam = `${i.toString().padStart(2, '0')}:00:00`;
                    const option = document.createElement('option');
                    option.value = jam;
                    option.textContent = jam.substring(0, 5);
                    waktuSelesai.appendChild(option);
                }
            }

            // Fungsi untuk ambil jam yang tersedia via AJAX
            function fetchAvailableTimes() {
                const tanggal = tanggalInput.value;
                const lapanganId = document.getElementById('lapangan_id').value;

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

                    const waktuMulaiLama = document.getElementById('waktuMulaiLama')?.value;
                    const waktuSelesaiLama = document.getElementById('waktuSelesaiLama')?.value;

                    waktuMulai.innerHTML = '<option value="">Pilih Waktu Mulai</option>';

                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.jam;
                        option.textContent = item.jam.substring(0, 5);
                        if (item.disabled && item.jam !== waktuMulaiLama) {
                            option.disabled = true;
                            option.textContent += ' (Terisi)';
                        }
                        waktuMulai.appendChild(option);
                    });
                    
                    // Set selected waktu selesai
                    if (waktuMulaiLama) {
                        waktuMulai.value = waktuMulaiLama;

                        const selectedHour = parseInt(waktuMulaiLama.split(':')[0]);

                        generateWaktuSelesai(selectedHour);
                        if (waktuSelesaiLama) {
                            waktuSelesai.value = waktuSelesaiLama;
                        }

                        waktuSelesai.dispatchEvent(new Event('change'));
                        waktuMulai.dispatchEvent(new Event('change'));
                    }

                    hitungTotalHarga();
                })
                .catch(error => console.error('Gagal ambil jadwal:', error));
            }

            function hitungTotalHarga() {
                const lapanganId = document.getElementById('lapangan_id').value;
                const waktuMulaiEl = document.getElementById('waktu_mulai');
                const waktuSelesaiEl = document.getElementById('waktu_selesai');
                const totalEl = document.getElementById('total');

                if (!lapanganId || !waktuMulaiEl.value || !waktuSelesaiEl.value) {
                    totalEl.value = 'Rp 0';
                    return;
                }

                const harga = hargaLapangan.find(l => l.id == lapanganId)?.price || 0;
                const durasi = parseInt(waktuSelesaiEl.value.split(':')[0]) - parseInt(waktuMulaiEl.value.split(':')[0]);
                const total = harga * durasi;

                totalEl.value = 'Rp ' + total.toLocaleString('id-ID');
            }

            function updateSisaPembayaran() {
                const totalText = document.getElementById('total').value;
                const jumlahPembayaran = parseInt(jumlahPembayaranEl.value.replace(/[^\d]/g, '') || 0);
                const jumlahPembayaranBaru = parseInt(jumlahPembayaranBaruEl.value.replace(/[^\d]/g, '') || 0);
                const total = parseInt(totalText.replace(/[^\d]/g, '') || 0);
                
                const sisa = total - (jumlahPembayaran + jumlahPembayaranBaru);

                sisaPembayaranEl.value = 'Rp ' + (sisa > 0 ? sisa : 0).toLocaleString('id-ID');
            }

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