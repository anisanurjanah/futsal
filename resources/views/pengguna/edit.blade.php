@extends('layout.main')

@section('title', 'User')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>User</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="ml-auto">
                                <h5>Edit Data</h5>
                            </div>
                        </div>
                        <div class="col mr-auto">
                            <div class="mr-auto float-right">
                                <a href="{{ url('/dashboard/pengguna') }}" class="btn btn-default">
                                    << Go Back to List </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ url('/dashboard/pengguna/' . $row->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="hidden" name="id" value="{{ $row->id }}">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ $row->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ $row->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        value="{{ $row->password }}" required>
                                </div>
                                <div class="form-group">
                                    <label>User Grup</label>
                                    <select name="role" id="role" class="form-control" required>
                                        @foreach ($role as $key => $value)
                                            <option value="{{ $key }}" {{ strtolower($row->role) == strtolower($key) ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>


@endsection

@section('script')

    <script></script>

@endsection
