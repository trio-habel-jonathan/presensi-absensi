@extends('layouts.pegawai')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Ajukan Izin/Cuti</h5>
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

            <form action="{{ route('pegawai.presensi.storeIzin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="text-sm font-weight-bold">Jenis Izin</label>
                    <select name="id_jenis_izin" id="id_jenis_izin" class="form-control" required>
                        <option value="">Pilih Jenis Izin</option>
                        @foreach ($jenisIzin as $izin)
                            <option value="{{ $izin->id_jenis_izin }}" {{ old('id_jenis_izin') == $izin->id_jenis_izin ? 'selected' : '' }}>
                                {{ $izin->nama_jenis_izin }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="text-sm font-weight-bold">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', \Carbon\Carbon::today('Asia/Jakarta')->format('Y-m-d')) }}" min="{{ \Carbon\Carbon::today('Asia/Jakarta')->format('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label class="text-sm font-weight-bold">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="4" required>{{ old('keterangan') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="text-sm font-weight-bold">Lampiran (Opsional, PDF/JPG/PNG)</label>
                    <input type="file" name="lampiran" id="lampiran" class="form-control" accept=".pdf,image/jpeg,image/png">
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                    <a href="{{ route('presensi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection