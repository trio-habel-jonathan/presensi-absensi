@extends('layouts.app')

@section('content')
    <div class="row mt-4 mx-4">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Detail Presensi {{ $pegawai->nama_pegawai ?? 'Tidak Ada Nama' }} - {{ \Carbon\Carbon::create($tahun, $bulan, 1)->translatedFormat('F Y') }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jadwal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jam Masuk</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jam Keluar</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Catatan</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto Kehadiran</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lampiran Izin</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan Izin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftarTanggal as $tanggal)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d/m/Y') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                @php $jadwal = $daftarJadwal->get($tanggal); @endphp
                                                {{ $jadwal ? ucfirst($jadwal->status) : 'Kerja' }}
                                                @if ($jadwal && $jadwal->keterangan)
                                                    ({{ $jadwal->keterangan }})
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                @php $presensi = $daftarPresensi->get($tanggal); @endphp
                                                {{ $presensi ? ucfirst($presensi->status) : '-' }}
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">
                                                @if ($presensi)
                                                    {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">
                                                @if ($presensi && $presensi->jam_keluar)
                                                    {{ \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $presensi && $presensi->catatan ? $presensi->catatan : '-' }}
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($presensi && $presensi->foto_masuk)
                                                <a href="{{ asset('storage/' . $presensi->foto_masuk) }}" target="_blank" class="text-sm font-weight-bold mb-0 text-primary">Lihat</a>
                                            @else
                                                <p class="text-sm font-weight-bold mb-0">-</p>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @php $izin = $daftarIzin->get($tanggal); @endphp
                                            @if ($izin && $izin->lampiran)
                                                <a href="{{ asset('storage/' . $izin->lampiran) }}" target="_blank" class="text-sm font-weight-bold mb-0 text-primary">Lihat</a>
                                            @else
                                                <p class="text-sm font-weight-bold mb-0">-</p>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $izin ? $izin->keterangan : '-' }}
                                            </p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-sm">Tidak ada data untuk bulan ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection