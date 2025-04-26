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
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-light">
                <h5 class="mb-0 text-white">Dashboard Presensi</h5>
            </div>
            <div class="card-body">
                <p>Selamat datang, {{ auth()->user()->name }}!</p>
                <p>Gunakan tombol di bawah untuk mencatat kehadiran atau mengajukan izin.</p>
                <div class="mt-4 d-flex flex-column justify-content-center align-items-center">
                    @if ($hasClockedIn && !$hasClockedOut)
                        <form action="{{ route('pegawai.presensi.clockOut') }}" method="POST"
                            class="container-fluid d-flex justify-content-center align-items-center p-0">
                            @csrf
                            <button type="submit"
                                class="w-75 w-lg-25 fs-6 text-uppercase rounded-circle ratio ratio-1x1 d-flex flex-column-reverse justify-content-center align-items-center btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin clock-out?')">
                                <div class="d-flex align-items-center justify-content-center"
                                    style="width: 100%; height: 100%">
                                    <svg class="mb-2" width="50%" height="50%" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.0001 2V12M18.3601 6.64C19.6185 7.89879 20.4754 9.50244 20.8224 11.2482C21.1694 12.9939 20.991 14.8034 20.3098 16.4478C19.6285 18.0921 18.4749 19.4976 16.9949 20.4864C15.515 21.4752 13.775 22.0029 11.9951 22.0029C10.2152 22.0029 8.47527 21.4752 6.99529 20.4864C5.51532 19.4976 4.36176 18.0921 3.68049 16.4478C2.99921 14.8034 2.82081 12.9939 3.16784 11.2482C3.51487 9.50244 4.37174 7.89879 5.63012 6.64"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <span
                                    class=" d-flex flex-column-reverse justify-content-start pb-4 align-items-center">Clock
                                    Out</span>
                            </button>
                        </form>
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <p class="fw-bold fs-4 text-uppercase">Good Job!!!</p>
                            <p>Anda Masuk pada Jam : {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}</p>

                        </div>
                    @else
                        <!-- Button trigger modal -->
                        <button type="button"
                            class="w-75 w-lg-25 fs-3 text-uppercase rounded-circle ratio ratio-1x1 d-flex justify-content-center align-items-center btn btn-success"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Clock In
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('pegawai.presensi.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="text-sm font-weight-bold">Foto Masuk</label>
                                                <input type="file" name="foto_masuk" id="foto_masuk" class="form-control"
                                                    accept="image/jpeg,image/png" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-sm font-weight-bold">Catatan (Opsional)</label>
                                                <textarea name="catatan" id="catatan" class="form-control" rows="4">{{ old('catatan') }}</textarea>
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <a href="{{ route('pegawai.presensi.izin') }}" class="btn btn-warning btn-sm">Ajukan Izin</a>
                </div>
            </div>
        </div>
    </div>
@endsection
