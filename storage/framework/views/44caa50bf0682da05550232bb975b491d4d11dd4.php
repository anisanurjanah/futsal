

<?php $__env->startSection('title', 'Reservasi'); ?>

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
                            
                            <div class="form-group mb-3">
                                <label class="d-block">Tipe Lapangan</label>
                                <div class="d-flex gap-3">
                                    <?php $__currentLoopData = $lapangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="lapangan_id"
                                                id="lapangan<?php echo e($item->id); ?>" value="<?php echo e($item->id); ?>"
                                                data-harga="<?php echo e($item->price); ?>" required>
                                            <label class="form-check-label" for="lapangan<?php echo e($item->id); ?>">
                                                <?php echo e($item->name); ?>

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
            const tanggalInput = document.getElementById('tanggal');
            const lapanganInputs = document.querySelectorAll('input[name="lapangan_id"]');

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

            tanggalInput.addEventListener('change', fetchAvailableTimes);
            lapanganInputs.forEach(input => {
                input.addEventListener('change', fetchAvailableTimes);
            });

            // Event listener untuk waktu mulai
            // waktuMulai.addEventListener('change', function() {
            //     filterWaktuSelesai();
            // });

            // Event listener untuk waktu selesai
            waktuSelesai.addEventListener('change', validateTime);

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
        const tanggal = sessionStorage.getItem('tanggalReservasi');
        const lapanganId = sessionStorage.getItem('lapanganId');

        if (tanggal) {
            $('#tanggal').val(tanggal);
        }

        if (lapanganId) {
            $(`#lapangan${lapanganId}`).prop('checked', true);
        }
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