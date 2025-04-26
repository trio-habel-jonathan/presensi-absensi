<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\Izin;
use App\Models\Jadwal;
use App\Models\ProfilPegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    /**
     * Nampilin daftar presensi pegawai.
     * - Ambil semua presensi + data pegawai.
     * - Tampilkan 10 data per halaman.
     * - Buka halaman 'admin.presensi.index'.
     */
    public function index()
    {
        $daftarPresensi = Presensi::with('profilPegawai')->paginate(10);
        return view('admin.presensi.index', compact('daftarPresensi'));
    }

    /**
     * Buka form buat bikin presensi baru.
     * - Ambil daftar pegawai buat dropdown.
     * - Buka halaman 'admin.presensi.create'.
     */
    public function create()
    {
        $daftarPegawai = ProfilPegawai::all();
        return view('admin.presensi.create', compact('daftarPegawai'));
    }

    /**
     * Simpan presensi baru ke database.
     * - Cek data masuk (ID pegawai, tanggal, jam, dll.) bener.
     * - Simpan foto masuk ke folder 'photos'.
     * - Buat presensi baru.
     * - Balik ke halaman daftar presensi dengan pesan sukses.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_profil_pegawai' => 'required|exists:profil_pegawai,id_profil_pegawai',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'foto_masuk' => 'required|file|mimes:jpg,png|max:2048',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,terlambat,izin,cuti',
            'catatan' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_masuk')) {
            $validated['foto_masuk'] = $request->file('foto_masuk')->store('photos', 'public');
        }
        Presensi::create($validated);
        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil dibuat.');
    }

    /**
     * Nampilin detail presensi pegawai untuk satu bulan.
     * - Ambil presensi berdasarkan ID, cek bulan dan tahun.
     * - Buat daftar tanggal dalam bulan (dari akhir ke awal).
     * - Ambil data presensi, izin, jadwal, dan pegawai untuk bulan itu.
     * - Buka halaman 'admin.presensi.detail'.
     */
    public function detail($id)
    {
        $presensi = Presensi::findOrFail($id);
        $employeeId = $presensi->id_profil_pegawai;
        $tanggal = Carbon::parse($presensi->tanggal);
        $bulan = $tanggal->month;
        $tahun = $tanggal->year;
    
        // Ambil tanggal dalam bulan (descending)
        $tanggalAwal = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();
        $daftarTanggal = [];
        for ($date = $tanggalAkhir; $date >= $tanggalAwal; $date->subDay()) {
            $daftarTanggal[] = $date->format('Y-m-d');
        }
    
        // Ambil presensi dan izin
        $daftarPresensi = Presensi::where('id_profil_pegawai', $employeeId)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->tanggal)->format('Y-m-d'));
    
        $daftarIzin = Izin::where('id_profil_pegawai', $employeeId)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->tanggal)->format('Y-m-d'));
    
        // Jadwal: cek DB, kalau kosong Sabtu/Minggu libur
        $daftarJadwal = Jadwal::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->tanggal)->format('Y-m-d'));
    
        $daftarJadwal = collect($daftarTanggal)->mapWithKeys(function ($tanggal) use ($daftarJadwal) {
            if (isset($daftarJadwal[$tanggal])) {
                return [$tanggal => $daftarJadwal[$tanggal]];
            }
            $date = Carbon::parse($tanggal);
            return [$tanggal => (object) [
                'status' => $date->isWeekend() ? 'libur' : 'kerja',
                'keterangan' => $date->isWeekend() ? 'Akhir pekan' : null,
            ]];
        });
    
        $pegawai = ProfilPegawai::find($employeeId);
    
        return view('admin.presensi.detail', compact('daftarTanggal', 'daftarPresensi', 'daftarIzin', 'daftarJadwal', 'bulan', 'tahun', 'pegawai'));
    }

    /**
     * Buka form buat edit presensi.
     * - Ambil data presensi yang mau diedit.
     * - Ambil daftar pegawai buat dropdown.
     * - Buka halaman 'admin.presensi.edit'.
     */
    public function edit(Presensi $presensi)
    {
        $daftarPegawai = ProfilPegawai::all();
        return view('admin.presensi.edit', compact('presensi', 'daftarPegawai'));
    }

    /**
     * Update data presensi di database.
     * - Cek data masuk, tapi foto boleh kosong.
     * - Kalau ada foto baru, simpan; kalau nggak, pakai foto lama.
     * - Update presensi.
     * - Balik ke halaman daftar presensi dengan pesan sukses.
     */
    public function update(Request $request, Presensi $presensi)
    {
        $validated = $request->validate([
            'id_profil_pegawai' => 'required|exists:profil_pegawai,id_profil_pegawai',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'foto_masuk' => 'nullable|file|mimes:jpg,png|max:2048',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,terlambat,izin,cuti',
            'catatan' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_masuk')) {
            $validated['foto_masuk'] = $request->file('foto_masuk')->store('photos', 'public');
        } else {
            $validated['foto_masuk'] = $presensi->foto_masuk;
        }
        $presensi->update($validated);
        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil diperbarui.');
    }

    /**
     * Hapus presensi dari database.
     * - Hapus data presensi yang dipilih.
     * - Balik ke halaman daftar presensi dengan pesan sukses.
     */
    public function destroy(Presensi $presensi)
    {
        $presensi->delete();
        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil dihapus.');
    }
}