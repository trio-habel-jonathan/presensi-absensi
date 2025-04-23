@extends('layouts.pegawai')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5>My Profile</h5>
        </div>
        <div class="card-body">
            @if ($profilPegawai)
                <p><strong>Name:</strong> {{ $profilPegawai->nama_pegawai }}</p>
                <p><strong>Identity Number:</strong> {{ $profilPegawai->no_identitas }}</p>
                <p><strong>Place, Date of Birth:</strong> {{ $profilPegawai->tempat_lahir }}, {{ $profilPegawai->tanggal_lahir }}</p>
                <p><strong>Gender:</strong> {{ $profilPegawai->jenis_kelamin == 'L' ? 'Male' : 'Female' }}</p>
                <p><strong>Phone:</strong> {{ $profilPegawai->no_telepon }}</p>
                <p><strong>Address:</strong> {{ $profilPegawai->alamat }}</p>
                <p><strong>Type:</strong> {{ $profilPegawai->jenisPegawai->nama_jenis_pegawai ?? '-' }}</p>
                <p><strong>Rank:</strong> {{ $profilPegawai->golongan->nama_golongan ?? '-' }}</p>
            @else
                <div class="alert alert-warning">
                    You haven't created a profile yet.
                    <a href="{{ route('pegawai.create') }}" class="btn btn-sm btn-primary ms-2">Create Now</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
