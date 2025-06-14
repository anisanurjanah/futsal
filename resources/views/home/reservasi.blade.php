@extends('layout.home')

@section('title', 'Home')

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
                                            <input class="form-check-input" type="radio" name="tipe_lapangan"
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
                                <label class="d-block">Metode Pembayaran</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment_bank" value="bank_transfer" required>
                                        <label class="form-check-label" for="payment_bank">
                                            Bank Transfer
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment_gopay" value="gopay" required>
                                        <label class="form-check-label" for="payment_gopay">
                                            GoPay
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment_qris" value="qris" required>
                                        <label class="form-check-label" for="payment_qris">
                                            QRIS
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
@endsection

@section('script')
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

        console.log("Tanggal:", tanggal);
        console.log("Lapangan ID:", lapanganId);

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
