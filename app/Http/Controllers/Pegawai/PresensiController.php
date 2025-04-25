<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\ProfilPegawai;
use App\Models\Izin;
use App\Models\JenisIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresensiController extends Controller
{

    /**
     * Nampilin dashboard presensi.
     * - Cek apakah user punya profil pegawai.
     * - Kalau belum, redirect ke create profil.
     * - Buka halaman 'pegawai.presensi.index'.
     */
    public function index()
    {
        $profilPegawai = ProfilPegawai::where('id_user', Auth::user()->id_user)->first();
        if (!$profilPegawai) {
            return redirect()->route('profil_pegawai.create')
                ->with('warning', 'Anda harus membuat profil terlebih dahulu.');
        }

        return view('pegawai.presensi.index', compact('profilPegawai'));
    }

    /**
     * Buka form buat clock in presensi.
     * - Cek apakah user punya profil pegawai.
     * - Buka halaman 'pegawai.presensi.create'.
     */
    public function create()
    {
        $profilPegawai = ProfilPegawai::where('id_user', Auth::user()->id_user)->first();
        if (!$profilPegawai) {
            return redirect()->route('profil_pegawai.create')
                ->with('warning', 'Anda harus membuat profil terlebih dahulu.');
        }

        return view('pegawai.presensi.create');
    }

    /**
     * Simpan presensi clock in ke database.
     * - Cek data valid.
     * - Set jam_masuk dari waktu submit (WIB).
     * - Set status otomatis: terlambat kalau jam_masuk > 08:00 WIB, hadir kalau <= 08:00 WIB.
     * - Simpan foto masuk.
     * - Simpan data presensi.
     * - Balik ke halaman presensi index dengan pesan sukses.
     */
    public function store(Request $request)
    {
        $profilPegawai = ProfilPegawai::where('id_user', Auth::user()->id_user)->first();
        if (!$profilPegawai) {
            return redirect()->route('profil_pegawai.create')
                ->with('warning', 'Anda harus membuat profil terlebih dahulu.');
        }

        $validated = $request->validate([
            'foto_masuk' => 'required|file|mimes:jpg,png|max:2048',
            'catatan' => 'nullable|string',
        ]);

        $validated['id_profil_pegawai'] = $profilPegawai->id_profil_pegawai;
        $validated['tanggal'] = Carbon::today('Asia/Jakarta')->format('Y-m-d');
        $validated['jam_masuk'] = Carbon::now('Asia/Jakarta')->format('H:i');

        // Hardcode status berdasarkan jam_masuk (WIB)
        $jamMasuk = Carbon::now('Asia/Jakarta');
        $validated['status'] = $jamMasuk->gt(Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta')) ? 'terlambat' : 'hadir';

        if ($request->hasFile('foto_masuk')) {
            $validated['foto_masuk'] = $request->file('foto_masuk')->store('fotos', 'public');
        }

        Presensi::create($validated);
        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil disimpan.');
    }

    /**
     * Buka form buat ajukan izin/cuti.
     * - Cek apakah user punya profil pegawai.
     * - Ambil data jenis_izin untuk dropdown.
     * - Buka halaman 'pegawai.presensi.izin'.
     */
    public function izin()
    {
        $profilPegawai = ProfilPegawai::where('id_user', Auth::user()->id_user)->first();
        if (!$profilPegawai) {
            return redirect()->route('profil_pegawai.create')
                ->with('warning', 'Anda harus membuat profil terlebih dahulu.');
        }

        $jenisIzin = JenisIzin::all();
        return view('pegawai.presensi.izin', compact('jenisIzin'));
    }

    /**
     * Simpan pengajuan izin/cuti ke tabel izin.
     * - Cek data valid.
     * - Simpan lampiran kalau ada.
     * - Simpan data izin dengan status pending.
     * - Balik ke halaman presensi index dengan pesan sukses.
     */
    public function storeIzin(Request $request)
    {
        $profilPegawai = ProfilPegawai::where('id_user', Auth::user()->id_user)->first();
        if (!$profilPegawai) {
            return redirect()->route('profil_pegawai.create')
                ->with('warning', 'Anda harus membuat profil terlebih dahulu.');
        }

        $validated = $request->validate([
            'id_jenis_izin' => 'required|exists:jenis_izin,id_jenis_izin',
            'tanggal' => 'required|date|after_or_equal:today',
            'keterangan' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $validated['id_profil_pegawai'] = $profilPegawai->id_profil_pegawai;
        $validated['tanggal'] = Carbon::parse($request->tanggal)->format('Y-m-d');
        $validated['status'] = 'pending';

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        Izin::create($validated);
        return redirect()->route('presensi.index')->with('success', 'Pengajuan izin/cuti berhasil disimpan.');
    }
}

/*
Catatan:
- Hanya role pegawai yang bisa akses (middleware role:pegawai).
- id_profil_pegawai otomatis dari profil pegawai user login.
- Clock In: simpan ke tabel presensi, status hadir/terlambat pake WIB (Asia/Jakarta).
- Izin/Cuti: simpan ke tabel izin, status default pending, lampiran di storage/public/lampiran.
- Pastikan php artisan storage:link dijalanin untuk foto dan lampiran.
*/