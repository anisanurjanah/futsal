@extends('layout.main')

@section('title', 'Lapangan')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Lapangan</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{ url('lapangan/edit') }}" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="{{ url('lapangan/index') }}" class="btn btn-default">
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
                                    <label>NAMA lapangan</label>
                                    <input type="text" class="form-control" name="namalapangan" id="namalapangan"
                                        autocomplete="off" value="{{ $row->namalapangan }}" required>
                                        <input type="hidden" name="id" value="{{ $row->id }}">
                                </div>
                                <div class="form-group">
                                    <label>HARGA PER JAM</label>
                                    <input type="number" class="form-control" name="hargaperjam" id="hargaperjam"
                                        autocomplete="off" value="{{ $row->hargaperjam }}" required>
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
