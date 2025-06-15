@extends('layout.main')

@section('title', 'Pelanggan')

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
        <div class="col-md-6">
            <form action="{{ url('/dashboard/pelanggan') }}" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="{{ url('/dashboard/pelanggan') }}" class="btn btn-default">
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
                                    <label>NAMA</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>EMAIL</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>NO TELEPON</label>
                                    <input type="text" class="form-control" name="no_telepon" id="no_telepon"
                                        autocomplete="off" required>
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
