<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\ProfilPegawai;
use App\Models\JenisIzin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    /**
     * Nampilin daftar izin.
     * - Ambil semua izin dengan relasi pegawai dan jenis izin.
     * - Tampilkan 10 data per halaman.
     * - Buka halaman 'admin.izin.index'.
     */
    public function index()
    {
        $izins = Izin::with(['profilPegawai', 'jenisIzin'])->paginate(10);
        return view('admin.izin.index', compact('izins'));
    }

    /**
     * Buka form buat bikin izin baru.
     * - Ambil data pegawai dan jenis izin untuk dropdown.
     * - Buka halaman 'admin.izin.create'.
     */
    public function create()
    {
        $profilPegawais = ProfilPegawai::all();
        $jenisIzins = JenisIzin::all();
        return view('admin.izin.create', compact('profilPegawais', 'jenisIzins'));
    }

    /**
     * Simpan izin baru ke database.
     * - Cek data izin valid.
     * - Simpan lampiran kalau ada.
     * - Simpan data izin.
     * - Balik ke halaman daftar izin dengan pesan sukses.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_profil_pegawai' => 'required|exists:profil_pegawai,id_profil_pegawai',
            'tanggal' => 'required|date',
            'id_jenis_izin' => 'required|exists:jenis_izin,id_jenis_izin',
            'keterangan' => 'required|string|max:255',
            'lampiran' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        Izin::create($validated);
        return redirect()->route('izin.index')->with('success', 'Izin berhasil dibuat.');
    }

    /**
     * Buka form buat edit izin.
     * - Ambil data izin, pegawai, dan jenis izin.
     * - Buka halaman 'admin.izin.edit'.
     */
    public function edit(Izin $izin)
    {
        $profilPegawais = ProfilPegawai::all();
        $jenisIzins = JenisIzin::all();
        return view('admin.izin.edit', compact('izin', 'profilPegawais', 'jenisIzins'));
    }

    /**
     * Update data izin di database.
     * - Cek data izin valid.
     * - Simpan lampiran baru kalau ada, tetap pake lama kalau nggak.
     * - Update data izin.
     * - Balik ke halaman daftar izin dengan pesan sukses.
     */
    public function update(Request $request, Izin $izin)
    {
        $validated = $request->validate([
            'id_profil_pegawai' => 'required|exists:profil_pegawai,id_profil_pegawai',
            'tanggal' => 'required|date',
            'id_jenis_izin' => 'required|exists:jenis_izin,id_jenis_izin',
            'keterangan' => 'required|string|max:255',
            'lampiran' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        } else {
            $validated['lampiran'] = $izin->lampiran;
        }

        $izin->update($validated);
        return redirect()->route('izin.index')->with('success', 'Izin berhasil diperbarui.');
    }

    /**
     * Hapus izin dari database.
     * - Hapus data izin berdasarkan ID.
     * - Balik ke halaman daftar izin dengan pesan sukses.
     */
    public function destroy(Izin $izin)
    {
        $izin->delete();
        return redirect()->route('izin.index')->with('success', 'Izin berhasil dihapus.');
    }
}
