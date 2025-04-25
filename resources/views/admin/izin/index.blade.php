@extends('layouts.app')

@section('content')
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl mt-3 bg-primary">
    <!-- Form pencarian pengguna -->
    <form method="GET" action="{{ route('izin.index') }}" style="z-index: 1000"
        class="d-flex align-items-center absolute w-100">
        <!-- Input untuk mencari berdasarkan nama pengguna -->
        <input type="search" name="search" class="form-control me-2 w-25" value="{{ request('search') }}"
            placeholder="Cari Pengguna">
        <!-- Input untuk mencari berdasarkan tanggal -->
        <input type="date" name="tanggal" class="form-control me-2 w-25" value="{{ request('tanggal') }}">
        <!-- Dropdown untuk memilih jenis (sakit, cuti, izin) -->
        <select name="jenis" class="form-control me-2 w-25">
            <option value="">Pilih Jenis</option>
            <option value="sakit" {{ request('jenis') == 'sakit' ? 'selected' : '' }}>Sakit</option>
            <option value="cuti" {{ request('jenis') == 'cuti' ? 'selected' : '' }}>Cuti</option>
            <option value="izin" {{ request('jenis') == 'izin' ? 'selected' : '' }}>Izin</option>
        </select>
        <!-- Dropdown untuk memilih status (pending, disetujui, ditolak) -->
        <select name="status" class="form-control me-2 w-25">
            <option value="">Pilih Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <!-- Tombol untuk melakukan pencarian -->
        <button type="submit" class="btn btn-primary m-0 w-15">Cari</button>
        <!-- Tombol untuk menghapus filter pencarian, muncul jika ada filter aktif -->
        @if (request()->input('search') || request()->input('tanggal') || request()->input('jenis') || request()->input('status'))
        <a href="{{ route('izin.index') }}" class="btn btn-primary m-0 w-15">Clear Pencarian</a>
        @endif
    </form>
</nav>


<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Daftar Izin</h6>

                <a href="{{route('izin.create')}}" class="btn btn-primary">Tambah Perizinan</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Pegawai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Jenis Izin</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Keterangan</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Tanggal</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Lampiran</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Status</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($izins as $izin)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $izin->profilPegawai->nama_pegawai ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{$izin->jenis }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $izin->keterangan }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{ $izin->tanggal->format('d/m/Y') }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <a href="{{ asset('storage/' . $izin->lampiran) }}" target="_blank">Lihat Lampiran</a>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{ ucfirst($izin->status) }}</p>
                                </td>
                                <td class="align-middle text-end">
                                    <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                        <a href="{{ route('izin.edit', $izin) }}"
                                            class="text-sm font-weight-bold mb-0 cursor-pointer">Edit</a>
                                        <form action="{{ route('izin.destroy', $izin) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-transparent border-0 text-sm font-weight-bold mb-0 ps-2 cursor-pointer text-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus izin ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-sm">Tidak ada data izin.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $izins->links() }}
    </div>
</div>
@endsection