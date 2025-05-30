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
            <a href="{{ url('booking/add') }}" class="btn btn-primary"> <i class="fas fa-plus"></i> Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="tabelbooking" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th class="text-center">NAMA MEMBER</th>
                        <th class="text-center">NAMA LAPANGAN</th>
                        <th class="text-center">TANGGAL</th>
                        <th class="text-center">DURASI</th>
                        <th class="text-center">TOTAL HARGA</th>
                        <th class="text-center">STATUS TRANSAKSI</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['namalapangan'] }}</td>
                            <td>{{ $item['tanggal'] }}</td>
                            <td class="text-center">{{ $item['durasi'] }} jam</td>
                            <td class="text-right">Rp.
                                {{ number_format($item['durasi'] * $item['hargaperjam'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if ($item['statustransaksi'] == 'Belum Lunas')
                                    <span class="badge bg-primary">{{ $item['statustransaksi'] }}</span>
                                @elseif ($item['statustransaksi'] == 'Lunas')
                                    <span class="badge bg-success">{{ $item['statustransaksi'] }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ url('booking/edit/' . $item['id']) }}" class="btn btn-xs btn-warning"
                                    title="Edit"><i class="fas fa-edit"></i> </a>
                                <button onclick="del({{ $item['id'] }})" class="btn btn-xs btn-danger" title="Hapus"><i
                                        class="fas fa-trash"></i> </button>
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
                    window.location.href = "{{ url('booking/booking/delete') }}/" + id;
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
@endsection
