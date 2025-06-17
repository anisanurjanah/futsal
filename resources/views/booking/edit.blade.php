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
        <div class="col-12">
            <form action="{{ url('/dashboard/reservasi/' . $row->id) }}" method="post" id="reservasiForm">
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
                        @method('PUT')
                        @csrf
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-5">
                            <div class="col-md-6 px-4">
                                <input type="hidden" name="id" value="{{ $row->id }}">
                                <input type="hidden" name="status" value="Ditunda">
                                <input type="hidden" id="waktuMulaiLama" value="{{ $row->waktu_mulai }}">
                                <input type="hidden" id="waktuSelesaiLama" value="{{ $row->waktu_selesai }}">

                                <div class="form-group">
                                    <label>PELANGGAN</label>
                                    <select name="pelanggan_id" id="pelanggan_id" class="form-control select2" required>
                                        <option value="">--Pilih Pelanggan--</option>
                                        @foreach ($pelanggan as $dt)
                                            <option value="{{ $dt->id }}"
                                                {{ (int)$row->pelanggan_id === (int)$dt->id ? 'selected' : '' }}>
                                                {{ $dt->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>LAPANGAN</label>
                                    <select name="lapangan_id" id="lapangan_id" class="form-control" required>
                                        <option value="">--Pilih Lapangan--</option>
                                        @foreach ($lapangan as $dt)
                                            <option value="{{ $dt->id }}"
                                                {{ (int)$row->lapangan_id === (int)$dt->id ? 'selected' : '' }}>
                                                {{ $dt->name }}
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
                                        @for ($i = 10; $i <= 20; $i++)
                                            @php
                                                $value = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00';
                                                $label = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                            @endphp
                                            <option value="{{ $value }}" {{ $row->waktu_mulai == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="waktu_selesai">Waktu Selesai</label>
                                    <select name="waktu_selesai" id="waktu_selesai" class="form-control" required>
                                        <option value="">Pilih Waktu Selesai</option>
                                        @for ($i = 11; $i <= 21; $i++)
                                            @php
                                                $value = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00';
                                                $label = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                            @endphp
                                            <option value="{{ $value }}" {{ $row->waktu_selesai == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 px-4">
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="text" class="form-control" id="total" name="total"
                                        value="Rp {{ number_format($row->pembayaran->total_pembayaran ?? 0, 0, ',', '.') }}"
                                        readonly disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
                                    <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran"
                                        value="{{ $row->pembayaran->pembayaranDetail->first()?->jumlah_pembayaran }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sisa_pembayaran">Sisa Pembayaran</label>
                                    <input type="text" class="form-control" id="sisa_pembayaran" name="sisa_pembayaran"
                                        value="Rp {{ number_format($row->pembayaran->sisa_pembayaran ?? 0, 0, ',', '.') }}" disabled>
                                </div>
                            </div>
                        </div>

                        <hr>

                        @if ($row->pembayaran->status_pembayaran === 'Belum Lunas')
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
                                            @foreach ($metodePembayaran as $metode)
                                                <option value="{{ $metode }}" {{ old('metode_pembayaran_baru') == $metode ? 'selected' : '' }}>
                                                    {{ $metode }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end p-3">
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session("success") }}',
        });
    </script>
@endif

@section('script')
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
            const hargaLapangan = @json($lapangan);

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
                const reservasiId = document.getElementById('id')?.value;

                if (!tanggal || !lapanganId) return;

                fetch('{{ url("/cek-jadwal") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tanggal: tanggal,
                        lapangan_id: lapanganId,
                        except_id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Available times:', data);

                    const waktuMulaiLama = document.getElementById('waktuMulaiLama')?.value;
                    const waktuSelesaiLama = document.getElementById('waktuSelesaiLama')?.value;

                    const waktuTerisi = data.filter(item => item.disabled).map(item => item.jam);

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

                    waktuMulai.addEventListener('change', function() {
                        const selectedHour = parseInt(this.value.split(':')[0]);
                        waktuSelesai.innerHTML = '<option value="">Pilih Waktu Selesai</option>';

                        for (let i = selectedHour + 1; i <= 21; i++) {
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
        @if (session('edit_gagal'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jadwal sudah ada',
            });
        @endif
    </script>
@endsection
