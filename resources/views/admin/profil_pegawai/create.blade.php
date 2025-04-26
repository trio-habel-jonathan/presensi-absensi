@extends('layouts.app')

@section('content')
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
                    <h6>Buat Profil Pegawai</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profil_pegawai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold">Foto Pegawai (JPG, PNG, Maks 2MB)</label>
                                <input type="file" name="foto_pegawai" class="form-control" accept="image/jpeg,image/png">
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Nama</label>
                                    <input type="text" name="nama_pegawai" class="form-control" value="{{ old('nama_pegawai') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Nomor Identitas</label>
                                    <input type="text" name="no_identitas" class="form-control" value="{{ old('no_identitas') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Nomor Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="4" required>{{ old('alamat') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold">Jenis Pegawai</label>
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
                                    <label class="form-label text-xs font-weight-bold">Golongan</label>
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
                                    <label class="form-label text-xs font-weight-bold">Akun Pengguna</label>
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
                            <a href="{{ route('profil_pegawai.index') }}" class="btn btn-secondary btn-sm me-2">Batal</a>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection