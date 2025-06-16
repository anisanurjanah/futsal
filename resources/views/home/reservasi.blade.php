@extends('layout.home')

@section('title', 'Reservasi')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reservasi Lapangan</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reservasi/add') }}" method="POST" id="reservasiForm">
                            @csrf
                            {{-- <input type="hidden" name="id_user" value="{{ session()->get('id_user') }}"> --}}
                            <div class="form-group mb-3">
                                <label class="d-block">Tipe Lapangan</label>
                                <div class="d-flex gap-3">
                                    @foreach ($lapangan as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="lapangan_id"
                                                id="lapangan{{ $item->id }}" value="{{ $item->id }}"
                                                data-harga="{{ $item->price }}" required>
                                            <label class="form-check-label" for="lapangan{{ $item->id }}">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    @endforeach
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
                                    @for ($i = 1; $i <= 24; $i++)
                                        @if ($i < 10)
                                            <option value="0{{ $i }}:00:00">0{{ $i }}:00</option>
                                        @else
                                            <option value="{{ $i }}:00:00">{{ $i }}:00</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="waktu_selesai">Waktu Selesai</label>
                                <select name="waktu_selesai" id="waktu_selesai" class="form-control" required>
                                    <option value="">Pilih Waktu Selesai</option>
                                    @for ($i = 1; $i <= 24; $i++)
                                        @if ($i < 10)
                                            <option value="0{{ $i }}:00:00">0{{ $i }}:00</option>
                                        @else
                                            <option value="{{ $i }}:00:00">{{ $i }}:00</option>
                                        @endif
                                    @endfor
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
                                <label for="total_harga">Total Harga</label>
                                <input type="text" class="form-control" id="total_harga" name="total_harga" value="Rp 0" readonly disabled>
                            </div>
                            <div class="form-group d-none" id="dp_wrapper">
                                <label for="harga_dp">Harga DP (50%)</label>
                                <input type="text" class="form-control" id="harga_dp" value="Rp 0" readonly disabled>
                            </div>

                            {{-- <div class="form-group mb-3">
                                <label class="d-block">Metode Pembayaran</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="payment_bank" value="bank_transfer" required>
                                        <label class="form-check-label" for="payment_bank">
                                            Bank Transfer
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="payment_gopay" value="gopay" required>
                                        <label class="form-check-label" for="payment_gopay">
                                            GoPay
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="payment_qris" value="qris" required>
                                        <label class="form-check-label" for="payment_qris">
                                            QRIS
                                        </label>
                                    </div>
                                </div>
                            </div> --}}

                            <button type="submit" class="btn btn-primary">Buat Reservasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                const totalHargaEl = document.getElementById('total_harga');
                const hargaDpEl = document.getElementById('harga_dp');
                const dpWrapper = document.getElementById('dp_wrapper');

                if (!lapanganRadio || !waktuMulaiEl.value || !waktuSelesaiEl.value) {
                    totalHargaEl.value = 'Rp 0';
                    hargaDpEl.value = 'Rp 0';
                    dpWrapper.classList.add('d-none');
                    return;
                }

                const lapanganId = lapanganRadio.value;
                const harga = hargaLapangan.find(l => l.id == lapanganId)?.price || 0;
                const durasi = parseInt(waktuSelesaiEl.value.split(':')[0]) - parseInt(waktuMulaiEl.value.split(':')[0]);
                const total = harga * durasi;

                totalHargaEl.value = 'Rp ' + total.toLocaleString('id-ID');

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
        @if (session('add_gagal'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jadwal sudah ada',
            });
        @endif
    </script>
@endsection
