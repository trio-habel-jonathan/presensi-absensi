<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Nampilin daftar jadwal.
     * - Ambil semua jadwal dari database.
     * - Tampilkan 10 data per halaman.
     * - Buka halaman 'admin.jadwal.index'.
     */
    public function index()
    {
        $jadwals = Jadwal::paginate(10);
        return view('admin.jadwal.index', compact('jadwals'));
    }

    /**
     * Buka form buat bikin jadwal baru.
     * - Buka halaman 'admin.jadwal.create'.
     */
    public function create()
    {
        return view('admin.jadwal.create');
    }

    /**
     * Simpan jadwal baru ke database.
     * - Cek tanggal, status, dan keterangan valid.
     * - Simpan data jadwal.
     * - Balik ke halaman daftar jadwal dengan pesan sukses.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:jadwal,tanggal',
            'status' => 'required|in:kerja,libur',
            'keterangan' => 'nullable|string|max:255',
        ]);
        Jadwal::create($request->only('tanggal', 'status', 'keterangan'));
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dibuat.');
    }

    /**
     * Buka form buat edit jadwal.
     * - Ambil data jadwal berdasarkan ID.
     * - Buka halaman 'admin.jadwal.edit'.
     */
    public function edit(Jadwal $jadwal)
    {
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    /**
     * Update data jadwal di database.
     * - Cek tanggal, status, dan keterangan valid.
     * - Update data jadwal.
     * - Balik ke halaman daftar jadwal dengan pesan sukses.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:jadwal,tanggal,' . $jadwal->id_jadwal . ',id_jadwal',
            'status' => 'required|in:kerja,libur',
            'keterangan' => 'nullable|string|max:255',
        ]);
        $jadwal->update($request->only('tanggal', 'status', 'keterangan'));
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Hapus jadwal dari database.
     * - Hapus data jadwal berdasarkan ID.
     * - Balik ke halaman daftar jadwal dengan pesan sukses.
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}

