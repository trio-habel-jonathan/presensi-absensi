@extends('layouts.app')

@section('content')
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Form Tambah Izin</h6>
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

                    <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="text-sm font-weight-bold">Pegawai</label>
                            <select name="id_profil_pegawai" class="form-control" required>
                                <option value="">Pilih Pegawai</option>
                                @foreach ($profilPegawais as $pegawai)
                                    <option value="{{ $pegawai->id_profil_pegawai }}" {{ old('id_profil_pegawai') == $pegawai->id_profil_pegawai ? 'selected' : '' }}>
                                        {{ $pegawai->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="text-sm font-weight-bold">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-sm font-weight-bold">Jenis Izin</label>
                            <select name="jenis" class="form-control" required>
                                <option value="">Pilih Jenis Izin</option>
                                <option value="sakit" {{ old('jenis') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="cuti" {{ old('jenis') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="izin" {{ old('jenis') == 'izin' ? 'selected' : '' }}>Izin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="text-sm font-weight-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="4" required>{{ old('keterangan') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="text-sm font-weight-bold">Lampiran (JPG, PNG, PDF)</label>
                            <input type="file" name="lampiran" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="text-sm font-weight-bold">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="disetujui" {{ old('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('izin.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection