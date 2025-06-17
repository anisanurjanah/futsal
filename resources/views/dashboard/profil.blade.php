@extends('layout.main')

@section('title', 'Profil')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Profil</h1>
        </div>
        <div class="col-sm-6">

        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-3">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="rounded mx-auto d-block" src="{{ url('img/profil/kosong.jpg') }}" width="200"
                            height="200">
                    </div>
                    <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                    <p class="text-muted text-center">{{ auth()->user()->email }}</p>
                    <br><br>
                </div>

            </div>

        </div>

        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <strong><i class="fas fa-user mr-1"></i> Nama Lengkap</strong>
                    <p class="text-muted ">{{ auth()->user()->name }}</p>
                    <hr>
                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted ">{{ auth()->user()->email }}</p>
                    <hr>
                    <strong><i class="fas fa-group mr-1"></i> Level User</strong>
                    <p class="text-muted ">{{ auth()->user()->role }}</p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> Jenis Kelamin</strong>
                    <p class="text-muted ">
                        @if (auth()->user()->role != 'Kasir')
                            Laki - laki
                        @else
                            Perempuan
                        @endif
                        </h5>
                    </p>
                    <hr>

                </div>

            </div>
        </div>

    </div>


@endsection

@section('script')

    <script>
        function add_sukses() {
            Swal.fire({
                icon: 'success',
                title: ' &nbsp; Tambah Data Berhasil'
            });
        }
    </script>

    @if (session('add_sukses'))
        <script>
            add_sukses();
        </script>
    @endif

@endsection
