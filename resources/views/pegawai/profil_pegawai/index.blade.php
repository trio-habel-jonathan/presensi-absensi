@extends('layouts.pegawai')

@section('content')
<div class="container mt-4">
    @if ($profilPegawai)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary ">
                <h5 class="mb-0 text-white">Profil Saya</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Foto Pegawai -->
                    <div class="col-md-4 text-center">
                        @if ($profilPegawai->foto_pegawai)
                            <img src="{{ asset('storage/' . $profilPegawai->foto_pegawai) }}" alt="Foto Pegawai" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <img src="{{ asset('img/default-profile.png') }}" alt="Foto Default" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @endif
                    </div>
                    <!-- Detail Pegawai -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Nama:</strong> {{ $profilPegawai->nama_pegawai }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Nomor Identitas:</strong> {{ $profilPegawai->no_identitas }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Tempat, Tanggal Lahir:</strong> {{ $profilPegawai->tempat_lahir }}, {{ Carbon\Carbon::parse($profilPegawai->tanggal_lahir)->format('d/m/Y') }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Jenis Kelamin:</strong> {{ $profilPegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Telepon:</strong> {{ $profilPegawai->no_telepon }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Alamat:</strong> {{ $profilPegawai->alamat }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Jenis Pegawai:</strong> {{ $profilPegawai->jenisPegawai->nama_jenis_pegawai ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Golongan:</strong> {{ $profilPegawai->golongan->nama_golongan ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Akun Pengguna:</strong> {{ $profilPegawai->user->email ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                </div>
            </div>
        </div>
        @else
        <div class="card shadow-sm border-0 text-center py-5">
            <div class="card-body">
                <h5 class="mb-3">Profil Belum Tersedia</h5>
                <p class="text-muted mb-4">
                    Kamu belum membuat profil pegawai. Yuk lengkapi dulu data dirimu agar bisa lanjut menggunakan fitur lainnya.
                </p>
                <a href="{{ route('pegawai.profil.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus-fill me-1"></i> Buat Profil Sekarang
                </a>
            </div>
        </div>
    @endif
    
</div>
@endsection