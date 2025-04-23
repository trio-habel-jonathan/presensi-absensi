@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Employee'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Employee Profile</h6>
                </div>
                <div class="card-body pt-0">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('profil_pegawai.update', $profilPegawai) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Name</label>
                            <input type="text" name="nama_pegawai" class="form-control" value="{{ old('nama_pegawai', $profilPegawai->nama_pegawai) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Identity Number</label>
                            <input type="text" name="no_identitas" class="form-control" value="{{ old('no_identitas', $profilPegawai->no_identitas) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Place of Birth</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $profilPegawai->tempat_lahir) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Date of Birth</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $profilPegawai->tanggal_lahir->format('Y-m-d')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Gender</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" {{ old('jenis_kelamin', $profilPegawai->jenis_kelamin) == 'L' ? 'selected' : '' }}>Male</option>
                                <option value="P" {{ old('jenis_kelamin', $profilPegawai->jenis_kelamin) == 'P' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Address</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $profilPegawai->alamat) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Phone Number</label>
                            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $profilPegawai->no_telepon) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Employee Type</label>
                            <select name="id_jenis_pegawai" class="form-select" required>
                                @foreach ($jenisPegawais as $jenis)
                                    <option value="{{ $jenis->id_jenis_pegawai }}" {{ old('id_jenis_pegawai', $profilPegawai->id_jenis_pegawai) == $jenis->id_jenis_pegawai ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Rank</label>
                            <select name="id_golongan" class="form-select" required>
                                @foreach ($golongans as $golongan)
                                    <option value="{{ $golongan->id_golongan }}" {{ old('id_golongan', $profilPegawai->id_golongan) == $golongan->id_golongan ? 'selected' : '' }}>
                                        {{ $golongan->nama_golongan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">User Account</label>
                            <select name="id_user" class="form-select" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id_user }}" {{ old('id_user', $profilPegawai->id_user) == $user->id_user ? 'selected' : '' }}>
                                        {{ $user->username }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary btn-sm me-2">Update</button>
                            <a href="{{ route('profil_pegawai.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection