

<?php $__env->startSection('title', 'Reservasi'); ?>

<?php $__env->startSection('content'); ?>

    <section class="content">
        <div class="container-fluid py-3">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Reservasi Lapangan</h3>
                        </div>
                        <div class="card-body p-4">
                            <form action="<?php echo e(route('reservasi/add')); ?>" method="POST" id="reservasiForm">
                                <?php echo csrf_field(); ?>

                                <div class="album">
                                    <div class="container">
                                        <h5 class="mb-4">Lapangan</h5>

                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                                        <?php $__currentLoopData = $lapangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col">
                                                <label class="d-block bg-body-tertiary bg-gradient text-center rounded py-4 lapangan-option">
                                                    <input type="radio"
                                                        id="lapangan<?php echo e($lap->id); ?>"
                                                        name="lapangan_id"
                                                        value="<?php echo e($lap->id); ?>"
                                                        class="form-check-input d-none">

                                                    <p class="m-0"><?php echo e($lap->name); ?></p>
                                                </label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
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
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
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
                                <div class="form-group mb-3">
                                    <label class="d-block">Pembayaran</label>
                                    <div class="d-flex flex-wrap gap-3">
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
                                </div>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="text" class="form-control" id="total" name="total" value="Rp 0" readonly disabled>
                                </div>
                                <div class="form-group d-none" id="dp_wrapper">
                                    <label for="harga_dp">Harga DP (50%)</label>
                                    <input type="text" class="form-control" id="harga_dp" value="Rp 0" readonly disabled>
                                </div>
                                <button type="submit" class="btn btn-primary">Buat Reservasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reservasiForm');
            const waktuMulai = document.getElementById('waktu_mulai');
            const waktuSelesai = document.getElementById('waktu_selesai');
            const waktuError = document.getElementById('waktuError');
            const tanggalInput = document.getElementById('tanggal');
            const hargaLapangan = <?php echo json_encode($lapangan, 15, 512) ?>;

            // SESSION
            const tanggal = sessionStorage.getItem('tanggalReservasi');
            const lapanganId = sessionStorage.getItem('lapanganId');

            if (tanggal) {
                tanggalInput.value = tanggal;
            }

            if (lapanganId) {
                document.querySelectorAll('input[name="lapangan_id"]').forEach(input => {
                    if (input.value === lapanganId) {
                        input.checked = true;

                        document.querySelectorAll('.lapangan-option').forEach(el => {
                            el.classList.remove('border', 'border-dark', 'shadow');
                        });

                        input.closest('.lapangan-option')?.classList.add('border', 'border-dark', 'shadow');

                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });
            }

            document.querySelectorAll('.lapangan-option input[type="radio"]').forEach(input => {
                input.addEventListener('change', function () {
                    sessionStorage.setItem('lapanganId', this.value);

                    document.querySelectorAll('.lapangan-option').forEach(el => {
                        el.classList.remove('border', 'border-dark', 'shadow');
                    });

                    this.closest('.lapangan-option').classList.add('border', 'border-dark', 'shadow');
                });
            });

            // Setelah semua element diambil
            if (tanggalInput.value && document.querySelector('input[name="lapangan_id"]:checked')) {
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

            // Validasi pembayaran
            function validatePaymentTipe() {
                const selected = document.querySelector('input[name="tipe_pembayaran"]:checked');
                if (!selected) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pembayaran Belum Dipilih',
                        text: 'Silakan pilih salah satu pembayaran terlebih dahulu.',
                    });
                    return false;
                }
                return true;
            }

            // Fungsi untuk ambil jam yang tersedia via AJAX
            function fetchAvailableTimes() {
                const tanggal = tanggalInput.value;
                const lapanganId = document.querySelector('input[name="lapangan_id"]:checked')?.value;

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
                const lapanganRadio = document.querySelector('input[name="lapangan_id"]:checked');
                const waktuMulaiEl = document.getElementById('waktu_mulai');
                const waktuSelesaiEl = document.getElementById('waktu_selesai');
                const totalEl = document.getElementById('total');
                const hargaDpEl = document.getElementById('harga_dp');
                const dpWrapper = document.getElementById('dp_wrapper');

                if (!lapanganRadio || !waktuMulaiEl.value || !waktuSelesaiEl.value) {
                    totalEl.value = 'Rp 0';
                    hargaDpEl.value = 'Rp 0';
                    dpWrapper.classList.add('d-none');
                    return;
                }

                const lapanganId = lapanganRadio.value;
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

            // Event listener untuk form submission
            form.addEventListener('submit', function(e) {
                const validTime = validateTime();
                const validPayment = validatePaymentMethod();

                if (!validTime || !validPayment) {
                    e.preventDefault();
                } else {
                    sessionStorage.removeItem('tanggalReservasi');
                    sessionStorage.removeItem('lapanganId');
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