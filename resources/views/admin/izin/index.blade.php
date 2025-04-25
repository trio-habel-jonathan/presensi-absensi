@extends('layouts.app')

@section('content')
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
                                    <p class="text-sm font-weight-bold mb-0">{{$izin->JenisIzin->nama_jenis_izin }}</p>
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