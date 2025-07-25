@extends('layout.home')

@section('title', 'Reservasi')

@section('content')

    <section class="content">
        <div class="container-fluid py-3">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Reservasi Lapangan</h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="row justify-content-center py-3">
                                <h1 class="text-center">FIT PLAZA</h1>
                            </div>

                            <form action="{{ route('reservasi/pembayaran') }}" method="POST" id="reservasiForm">
                                @csrf
                                <div class="album">
                                    <div class="container">
                                        <h5 class="mb-4">Lapangan</h5>

                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                                            @foreach ($lapangan as $lap)
                                                <div class="col">
                                                    <label class="d-block bg-body-tertiary bg-gradient text-center rounded py-4 lapangan-option" style="cursor: pointer;">
                                                        <input type="radio"
                                                            id="lapangan{{ $lap->id }}"
                                                            name="lapangan_id"
                                                            value="{{ $lap->id }}"
                                                            class="form-check-input d-none">

                                                        <p class="m-0">{{ $lap->name }}</p>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="nomor_telepon">Nomor Telepon</label>
                                            <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="waktu_mulai">Waktu Mulai</label>
                                            <select name="waktu_mulai" id="waktu_mulai" class="form-control" required>
                                                <option value="">Pilih Waktu Mulai</option>
                                                @for ($i = 10; $i <= 20; $i++)
                                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00:00">
                                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="waktu_selesai">Waktu Selesai</label>
                                            <select name="waktu_selesai" id="waktu_selesai" class="form-control" required>
                                                <option value="">Pilih Waktu Selesai</option>
                                                @for ($i = 11; $i <= 21; $i++)
                                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00:00">
                                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="d-block">Pembayaran</label>
                                    <div class="p-2 gap-3">
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

                                <div class="d-flex justify-content-end py-3">
                                    <button type="submit" class="btn btn-primary">Buat Reservasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reservasiForm');
            const waktuMulai = document.getElementById('waktu_mulai');
            const waktuSelesai = document.getElementById('waktu_selesai');
            const waktuError = document.getElementById('waktuError');
            const tanggalInput = document.getElementById('tanggal');
            const hargaLapangan = @json($lapangan);

            // SESSION
            const tanggal = sessionStorage.getItem('tanggalReservasi');
            const lapanganId = sessionStorage.getItem('lapanganId');

            if (tanggal) {
                tanggalInput.value = tanggal;
                sessionStorage.removeItem('tanggalReservasi');
            }

            if (lapanganId) {
                document.querySelectorAll('input[name="lapangan_id"]').forEach(input => {
                    if (input.value === lapanganId) {
                        input.checked = true;
                        fetchAvailableTimes()

                        document.querySelectorAll('.lapangan-option').forEach(el => {
                            el.classList.remove('border', 'border-dark', 'shadow');
                        });

                        input.closest('.lapangan-option')?.classList.add('border', 'border-dark', 'shadow');

                        input.dispatchEvent(new Event('change', { bubbles: true }));

                        sessionStorage.removeItem('lapanganId');
                    }
                });
            }

            document.querySelectorAll('.lapangan-option input[type="radio"]').forEach(input => {
                input.addEventListener('change', function () {
                    fetchAvailableTimes()

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

            tanggalInput.addEventListener('change', function() {
                fetchAvailableTimes();
            });

            // Event listener untuk waktu
            waktuMulai.addEventListener('change', hitungTotalHarga);
            waktuSelesai.addEventListener('change', function() {
                validateTime();
                hitungTotalHarga();
            });

            document.querySelectorAll('input[name="tipe_pembayaran"]').forEach(input => {
                input.addEventListener('change', hitungTotalHarga);
            });

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
                
                fetch('{{ url("/cek-jadwal") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

                    const waktuTersedia = data.map(item => item.jam);
                    const waktuTerisi = data.filter(item => item.disabled).map(item => item.jam);

                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.jam;
                        option.textContent = item.jam.substring(0, 5);

                        if (item.disabled) {
                            option.disabled = true;
                            option.textContent += ' (Terisi)';
                        }

                        waktuMulai.appendChild(option);
                    });

                    waktuMulai.addEventListener('change', function() {
                        const selectedHour = parseInt(this.value.split(':')[0]);
                        waktuSelesai.innerHTML = '<option value="">Pilih Waktu Selesai</option>';

                        for (let i = selectedHour + 1; i <= 20; i++) {
                            const jamMulai = selectedHour;
                            const jamSelesai = i;
                            let konflik = false;

                            for (let jam = jamMulai; jam < jamSelesai; jam++) {
                                const jamCheck = `${jam.toString().padStart(2, '0')}:00:00`;
                                if (waktuTerisi.includes(jamCheck)) {
                                    konflik = true;
                                    break;
                                }
                            }

                            if (!konflik) {
                                const jam = `${jamSelesai.toString().padStart(2, '0')}:00:00`;
                                const option = document.createElement('option');
                                option.value = jam;
                                option.textContent = jam.substring(0, 5);
                                waktuSelesai.appendChild(option);
                            }
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
        @if (session('add_gagal'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jadwal sudah ada',
            });
        @endif
    </script>
@endsection
