@extends('layouts.app')

@section('content')
    {{-- @include('layouts.navbars.auth.topnav', ['title' => 'Edit Presensi']) --}}
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Data Presensi</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('presensi.update', $presensi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="id_profil_pegawai" class="form-label">Pegawai</label>
                            <select name="id_profil_pegawai" id="id_profil_pegawai" class="form-select" required>
                                <option value="">Pilih Pegawai</option>
                                @foreach ($profilPegawais as $pegawai)
                                    <option value="{{ $pegawai->id_profil_pegawai }}" {{ old('id_profil_pegawai', $presensi->id_profil_pegawai) == $pegawai->id_profil_pegawai ? 'selected' : '' }}>
                                        {{ $pegawai->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $presensi->tanggal->format('Y-m-d')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jam_masuk" class="form-label">Jam Masuk</label>
                            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" value="{{ old('jam_masuk', $presensi->jam_masuk) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto_masuk" class="form-label">Foto Masuk (Biarkan kosong jika tidak ingin mengganti)</label>
                            <input type="file" name="foto_masuk" id="foto_masuk" class="form-control" accept="image/jpeg,image/png">
                            @if ($presensi->foto_masuk)
                                <img src="{{ asset('storage/' . $presensi->foto_masuk) }}" alt="Foto Masuk" class="img-thumbnail mt-2" style="max-width: 100px;">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="jam_keluar" class="form-label">Jam Keluar (Opsional)</label>
                            <input type="time" name="jam_keluar" id="jam_keluar" class="form-control" value="{{ old('jam_keluar', $presensi->jam_keluar) }}">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="hadir" {{ old('status', $presensi->status) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="terlambat" {{ old('status', $presensi->status) == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="izin" {{ old('status', $presensi->status) == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="cuti" {{ old('status', $presensi->status) == 'cuti' ? 'selected' : '' }}>Cuti</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" id="catatan" class="form-control" rows="4">{{ old('catatan', $presensi->catatan) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="{{ route('presensi.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection