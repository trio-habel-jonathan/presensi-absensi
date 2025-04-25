@extends('layouts.pegawai')

@section('content')
<div class="container mt-4">
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Dashboard Presensi</h5>
        </div>
        <div class="card-body">
            <p>Selamat datang, {{ auth()->user()->name }}!</p>
            <p>Gunakan tombol di bawah untuk mencatat kehadiran atau mengajukan izin.</p>
            <div class="mt-4">
                <a href="{{ route('pegawai.presensi.create') }}" class="btn btn-success btn-sm">Clock In</a>
                <a href="{{ route('izin.create') }}" class="btn btn-warning btn-sm">Ajukan Izin</a>
            </div>
        </div>
    </div>
</div>
@endsection