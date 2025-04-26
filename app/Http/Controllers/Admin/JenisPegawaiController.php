<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPegawai;
use Illuminate\Http\Request;

class JenisPegawaiController extends Controller
{
    /**
     * Nampilin daftar jenis pegawai.
     * - Ambil semua jenis pegawai dari database.
     * - Tampilkan 10 data per halaman.
     * - Buka halaman 'admin.jenis_pegawai.index'.
     */
    public function index()
    {
        $jenisPegawais = JenisPegawai::paginate(10);
        return view('admin.jenis_pegawai.index', compact('jenisPegawais'));
    }

    /**
     * Buka form buat bikin jenis pegawai baru.
     * - Buka halaman 'admin.jenis_pegawai.create'.
     */
    public function create()
    {
        return view('admin.jenis_pegawai.create');
    }

    /**
     * Simpan jenis pegawai baru ke database.
     * - Cek nama jenis pegawai valid.
     * - Simpan data jenis pegawai.
     * - Balik ke halaman daftar jenis pegawai dengan pesan sukses.
     */
    public function store(Request $request)
    {
        $request->validate(['nama_jenis_pegawai' => 'required|string|max:255']);
        JenisPegawai::create($request->only('nama_jenis_pegawai'));
        return redirect()->route('jenis_pegawai.index')->with('success', 'Jenis pegawai berhasil dibuat.');
    }

    /**
     * Buka form buat edit jenis pegawai.
     * - Ambil data jenis pegawai berdasarkan ID.
     * - Buka halaman 'admin.jenis_pegawai.edit'.
     */
    public function edit(JenisPegawai $jenisPegawai)
    {
        return view('admin.jenis_pegawai.edit', compact('jenisPegawai'));
    }

    /**
     * Update data jenis pegawai di database.
     * - Cek nama jenis pegawai valid.
     * - Update data jenis pegawai.
     * - Balik ke halaman daftar jenis pegawai dengan pesan sukses.
     */
    public function update(Request $request, JenisPegawai $jenisPegawai)
    {
        $request->validate(['nama_jenis_pegawai' => 'required|string|max:255']);
        $jenisPegawai->update($request->only('nama_jenis_pegawai'));
        return redirect()->route('jenis_pegawai.index')->with('success', 'Jenis pegawai berhasil diperbarui.');
    }

    /**
     * Hapus jenis pegawai dari database.
     * - Hapus data jenis pegawai berdasarkan ID.
     * - Balik ke halaman daftar jenis pegawai dengan pesan sukses.
     */
    public function destroy(JenisPegawai $jenisPegawai)
    {
        $jenisPegawai->delete();
        return redirect()->route('jenis_pegawai.index')->with('success', 'Jenis pegawai berhasil dihapus.');
    }
}
