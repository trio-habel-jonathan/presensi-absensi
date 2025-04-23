@extends('layouts.app')

@section('content')
    {{-- @include('layouts.navbars.auth.topnav', ['title' => 'Add Employee']) --}}
    <div class="row mt-4 mx-4">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Create Employee Profile</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profil_pegawai.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Name</label>
                                    <input type="text" name="nama_pegawai" class="form-control" value="{{ old('nama_pegawai') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Identity Number</label>
                                    <input type="text" name="no_identitas" class="form-control" value="{{ old('no_identitas') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Place of Birth</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Date of Birth</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Gender</label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Male</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Phone Number</label>
                                    <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Address</label>
                            <textarea name="alamat" class="form-control" rows="4" required>{{ old('alamat') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Employee Type</label>
                                    <select name="id_jenis_pegawai" class="form-select" required>
                                        @foreach ($jenisPegawais as $jenis)
                                            <option value="{{ $jenis->id_jenis_pegawai }}" {{ old('id_jenis_pegawai') == $jenis->id_jenis_pegawai ? 'selected' : '' }}>
                                                {{ $jenis->nama_jenis_pegawai }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Rank</label>
                                    <select name="id_golongan" class="form-select" required>
                                        @foreach ($golongans as $golongan)
                                            <option value="{{ $golongan->id_golongan }}" {{ old('id_golongan') == $golongan->id_golongan ? 'selected' : '' }}>
                                                {{ $golongan->nama_golongan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">User Account</label>
                                    <select name="id_user" class="form-select" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                                                {{ $user->username }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('profil_pegawai.index') }}" class="btn btn-secondary btn-sm me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection