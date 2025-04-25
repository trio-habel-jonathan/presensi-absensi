@extends('layouts.app')

@section('content')
{{-- @include('layouts.navbars.auth.topnav', ['title' => 'Employee Management']) --}}
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl mt-3 bg-primary">
    <form method="GET" action="{{ route('profil_pegawai.index') }}" style="z-index: 1000"
        class="d-flex align-items-center absolute  w-100">
        <input type="search" name="search" class="form-control me-2 w-50" value="{{ request('search') }}"
            placeholder="Cari Pengguna">
        <button type="submit" class="btn btn-primary m-0 w-15">Cari</button>
        {{-- Muncul tombol ini kalau search dilakukan --}}
        @if (request()->input('search'))
        <a href="{{route('profil_pegawai.index')}}" class="btn btn-primary m-0 w-15">Clear Pencarian</a>
        @endif
    </form>
</nav>
<div class="row mt-4 mx-4">
    <div class="col-12">
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Pegawai</h6>
                <a href="{{ route('profil_pegawai.create') }}" class="btn btn-primary btn-sm">Tambah Pegawai</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Nomor Identitas</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Jenis Pegawai</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Tanggal Dibuat</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($profilPegawais as $profil)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $profil->nama_pegawai }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $profil->no_identitas }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{
                                        $profil->jenisPegawai->nama_jenis_pegawai ?? 'N/A' }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{ $profil->created_at->format('d/m/Y') }}
                                    </p>
                                </td>
                                <td class="align-middle text-end">
                                    <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                        <a href="{{ route('profil_pegawai.edit', $profil) }}"
                                            class="text-sm font-weight-bold mb-0 cursor-pointer text-primary">Edit</a>
                                        <form action="{{ route('profil_pegawai.destroy', $profil) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer text-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-sm">Tidak ada pegawai yang ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $profilPegawais->links() }}
    </div>
</div>
@endsection