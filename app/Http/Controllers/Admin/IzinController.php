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
     * Nampilin daftar izin dengan fitur pencarian.
     * - Ambil semua izin dengan relasi pegawai dan jenis izin.
     * - Filter berdasarkan nama pengguna, tanggal, jenis izin, dan status jika ada.
     * - Tampilkan 10 data per halaman.
     * - Buka halaman 'admin.izin.index'.
     */
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari request
        $search = $request->input('search');
        $tanggal = $request->input('tanggal');
        $jenis = $request->input('jenis');
        $status = $request->input('status');

        // Query izin dengan relasi profilPegawai
        $izins = Izin::with(['profilPegawai'])
            ->when($search, function ($query, $search) {
                // Filter berdasarkan nama pengguna
                $query->whereHas('profilPegawai', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->when($tanggal, function ($query, $tanggal) {
                // Filter berdasarkan tanggal
                $query->where('tanggal', $tanggal);
            })
            ->when($jenis, function ($query, $jenis) {
                // Filter berdasarkan jenis izin
                $query->where('jenis', $jenis  );

            })
            ->when($status, function ($query, $status) {
                // Filter berdasarkan status
                $query->where('status', $status);
            })
            ->paginate(10);

        // Tampilkan halaman dengan data izin
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
        return view('admin.izin.create', compact('profilPegawais'));
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
            'jenis' => 'required',
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
