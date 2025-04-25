@extends('layouts.app')

@section('content')
    {{-- @include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Jenis Pegawai']) --}}
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
                    <h6>Jenis Pegawai</h6>
                    <a href="{{ route('jenis_pegawai.create') }}" class="btn btn-primary btn-sm">Tambah Jenis Pegawai</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Jenis Pegawai</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Dibuat</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jenisPegawais as $jenis)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $jenis->nama_jenis_pegawai }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $jenis->created_at->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a href="{{ route('jenis_pegawai.edit', $jenis) }}" class="text-sm font-weight-bold mb-0 cursor-pointer text-primary">Edit</a>
                                                <form action="{{ route('jenis_pegawai.destroy', $jenis) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jenis pegawai ini?')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-sm">Tidak ada jenis pegawai yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{ $jenisPegawais->links() }}
        </div>
    </div>
@endsection