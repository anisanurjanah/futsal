@extends('layout.main')

@section('title', 'Booking')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Data</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md">
            <form action="{{ url('/dashboard/reservasi') }}" method="post" id="bookingForm">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="{{ url('/dashboard/reservasi') }}" class="btn btn-default">
                                        <i class="fas fa fa-reply"></i> Kembali </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Pelanggan</label>
                                    <select name="pelanggan_id" id="pelanggan_id" class="form-control select2" required>
                                        <option value="">--Pilih Pelanggan--</option>
                                        @foreach ($pelanggan as $dt)
                                            <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Lapangan</label>
                                    <select name="lapangan_id" id="lapangan_id" class="form-control" required>
                                        <option value="">--Pilih Lapangan--</option>
                                        @foreach ($lapangan as $dt)
                                            <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required
                                        min="{{ date('Y-m-d') }}">
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
                                                <option value="0{{ $i }}:00:00">0{{ $i }}:00
                                                </option>
                                            @else
                                                <option value="{{ $i }}:00:00">{{ $i }}:00</option>
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="total_harga">Total Harga</label>
                                    <input type="number" class="form-control" id="total_harga" name="total_harga" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Tipe Pembayaran</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="tipe_pembayaran" name="tipe_pembayaran"
                                            value="Down Payment">Down Payment
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="tipe_pembayaran" name="tipe_pembayaran"
                                            value="Lunas">Lunas
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
                                    <input type="number" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="sisa_pembayaran">Sisa Pembayaran</label>
                                    <input type="number" class="form-control" id="sisa_pembayaran" name="sisa_pembayaran" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="total_pembayaran">Total Pembayaran</label>
                                    <input type="number" class="form-control" id="total_pembayaran" name="total_pembayaran" disabled>
                                </div>
                                <div class="form-group mb-3">
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
                                </div>
                                <div class="form-group">
                                    <label>Status Pembayaran</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="status_pembayaran" name="status_pembayaran"
                                            value="Belum Lunas">Belum Lunas
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="status_pembayaran" name="status_pembayaran"
                                            value="Lunas">Lunas
                                    </div>
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

@endsection

@section('script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bookingForm');
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
        @if (session('add_gagal'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jadwal sudah ada',
            });
        @endif
    </script>
@endsection
