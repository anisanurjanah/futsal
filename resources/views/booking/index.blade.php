@extends('layout.main')

@section('title', 'Booking')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Booking</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ url('/dashboard/reservasi/create') }}" class="btn btn-primary"> <i class="fas fa-plus"></i> Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="tabelbooking" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th class="text-center">NAMA PELANGGAN</th>
                        <th class="text-center">LAPANGAN</th>
                        <th class="text-center">TANGGAL</th>
                        <th class="text-center">DURASI</th>
                        <th class="text-center">TOTAL HARGA</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">PEMBAYARAN</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['nama_lapangan'] }}</td>
                            <td>{{ $item['tanggal'] }}</td>
                            <td class="text-center">{{ $item['durasi'] }} jam</td>
                            <td class="text-right">Rp.
                                {{ number_format($item['durasi'] * $item['harga'], 0, ',', '.') }}</td>
                            <td>
                                @if ($item['status'] === 'Ditunda')
                                    <span class="badge bg-warning text-dark">{{ $item['status'] }}</span>
                                @elseif ($item['status'] === 'Berlangsung')
                                    <span class="badge bg-info text-dark">{{ $item['status'] }}</span>
                                @elseif ($item['status'] === 'Selesai')
                                    <span class="badge bg-success">{{ $item['status'] }}</span>
                                @elseif ($item['status'] === 'Dibatalkan')
                                    <span class="badge bg-danger">{{ $item['status'] }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $item['status'] }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item['status_pembayaran'] == 'Belum Lunas')
                                    <span class="badge bg-primary">{{ $item['status_pembayaran'] }}</span>
                                @elseif ($item['status_pembayaran'] == 'Lunas')
                                    <span class="badge bg-success">{{ $item['status_pembayaran'] }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ url('/dashboard/reservasi/' . $item['id']) }}" class="btn btn-xs btn-primary"
                                    title="Show"><i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ url('/dashboard/reservasi/' . $item['id']) . '/edit' }}" class="btn btn-xs btn-warning"
                                    title="Edit"><i class="fas fa-edit"></i>
                                </a>

                                <form id="cancel-form-{{ $item['id'] }}" action="{{ url('/dashboard/reservasi/' . $item['id'] . '/cancel') }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <button onclick="cancel({{ $item['id'] }})" class="btn btn-xs btn-secondary" title="Batalkan reservasi">
                                    <i class="fas fa-ban"></i>
                                </button>

                                <form id="delete-form-{{ $item['id'] }}" action="{{ url('/dashboard/reservasi/' . $item['id']) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button onclick="del({{ $item['id'] }})" class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('script')

    <script>
        $('#tabelbooking').bookingTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            scrollX: true,
        });

        function add_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });

            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Tambah Data Berhasil'
            });
        }

        function edit_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });

            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Update Data Berhasil'
            });
        }

        function delete_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });

            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Hapus Data Berhasil'
            });
        }

        function cancel_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });

            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Reservasi berhasil dibatalkan'
            });
        }

        function del(id) {
            Swal.fire({
                title: "Ingin Menghapus Data ini?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function cancel(id) {
            Swal.fire({
                title: "Yakin ingin membatalkan reservasi ini?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Batalkan',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel-form-' + id).submit();
                }
            });
        }
    </script>

    @if (session('add_sukses'))
        <script>
            add_sukses();
        </script>
    @endif

    @if (session('edit_sukses'))
        <script>
            edit_sukses();
        </script>
    @endif

    @if (session('delete_sukses'))
        <script>
            delete_sukses();
        </script>
    @endif

    @if (session('cancel_sukses'))
        <script>
            cancel_sukses();
        </script>
    @endif
@endsection
