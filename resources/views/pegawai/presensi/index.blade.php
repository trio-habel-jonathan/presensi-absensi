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
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
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
                @if ($hasClockedIn && !$hasClockedOut)
                    <form action="{{ route('pegawai.presensi.clockOut') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin clock-out?')">Clock Out</button>
                    </form>
                @else
                    <a href="{{ route('pegawai.presensi.create') }}" class="btn btn-success btn-sm">Clock In</a>
                @endif
                <a href="{{ route('pegawai.presensi.izin') }}" class="btn btn-warning btn-sm">Ajukan Izin</a>
            </div>
        </div>
    </div>
</div>
@endsection