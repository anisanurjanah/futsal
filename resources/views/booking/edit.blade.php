@extends('layout.main')

@section('title', 'Booking')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Booking</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md">
            <form action="{{ route('booking/update') }}" method="POST" id="reservasiForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="{{ url('booking/index') }}" class="btn btn-default">
                                        <i class="fas fa fa-reply"></i> Kembali </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="{{ $row->id }}">
                                <input type="hidden" name="idmember" value="{{ $row->id_pelanggan }}">
                                <div class="form-group">
                                    <label>NAMA LAPANGAN</label>
                                    <select name="id_lapangan" id="id_lapangan" class="form-control" required>
                                        <option value="">--Pilih Lapangan--</option>
                                        @foreach ($lapangan as $dt)
                                            <option value="{{ $dt->id }}"
                                                {{ $row->id_lapangan == $dt->id ? 'selected="selected"' : null }}>
                                                {{ $dt->namalapangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        value="{{ $row->tanggal }}" required min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="waktu_mulai">Waktu Mulai</label>
                                    <select name="waktu_mulai" id="waktu_mulai" class="form-control" required>
                                        <option value="">Pilih Waktu Mulai</option>
                                        @for ($i = 1; $i <= 24; $i++)
                                            @if ($i < 10)
                                                @if ($row->waktu_mulai == '0' . $i . ':00:00')
                                                    <option value="0{{ $i }}:00:00" selected>
                                                        {{ $i }}:00
                                                    </option>
                                                @else
                                                    <option value="0{{ $i }}:00:00">
                                                        {{ $i }}:00
                                                    </option>.
                                                @endif
                                            @else
                                                @if ($row->waktu_mulai == $i . ':00:00')
                                                    <option value="{{ $i }}:00:00" selected>
                                                        {{ $i }}:00
                                                    </option>
                                                @else
                                                    <option value="{{ $i }}:00:00">
                                                        {{ $i }}:00
                                                    </option>
                                                @endif
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
                                                @if ($row->waktu_selesai == '0' . $i . ':00:00')
                                                    <option value="0{{ $i }}:00:00" selected>
                                                        {{ $i }}:00
                                                    </option>
                                                @else
                                                    <option value="0{{ $i }}:00:00">
                                                        {{ $i }}:00
                                                    </option>
                                                @endif
                                            @else
                                                @if ($row->waktu_selesai == $i . ':00:00')
                                                    <option value="{{ $i }}:00:00" selected>
                                                        {{ $i }}:00
                                                    </option>
                                                @else
                                                    <option value="{{ $i }}:00:00">
                                                        {{ $i }}:00
                                                    </option>
                                                @endif
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>STATUS TRANSAKSI</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="sts1" name="statustransaksi"
                                            value="Belum Lunas"
                                            {{ old('status', $row->status) == 'Belum Lunas' ? 'checked' : '' }}>BELUM
                                        LUNAS
                                        </input>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="sts2" name="statustransaksi"
                                            value="Lunas"
                                            {{ old('status', $row->status) == 'Lunas' ? 'checked' : '' }}>LUNAS
                                        </input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>

            </form>

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
        @if (session('edit_gagal'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jadwal sudah ada',
            });
        @endif
    </script>
@endsection
