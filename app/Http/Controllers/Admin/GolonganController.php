<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    /**
     * Nampilin daftar golongan.
     * - Ambil semua golongan dari database.
     * - Tampilkan 10 data per halaman.
     * - Buka halaman 'golongan.index'.
     */
    public function index()
    {
        $golongans = Golongan::paginate(10);
        return view('admin.golongan.index', compact('golongans'));
    }

    /**
     * Buka form buat bikin golongan baru.
     * - Buka halaman 'golongan.create'.
     */
    public function create()
    {
        return view('admin.golongan.create');
    }

    /**
     * Simpan golongan baru ke database.
     * - Cek nama golongan valid.
     * - Simpan data golongan.
     * - Balik ke halaman daftar golongan dengan pesan sukses.
     */
    public function store(Request $request)
    {
        $request->validate(['nama_golongan' => 'required|string|max:255']);
        Golongan::create($request->only('nama_golongan'));
        return redirect()->route('golongan.index')->with('success', 'Golongan berhasil dibuat.');
    }

    /**
     * Buka form buat edit golongan.
     * - Ambil data golongan berdasarkan ID.
     * - Buka halaman 'golongan.edit'.
     */
    public function edit(Golongan $golongan)
    {
        return view('admin.golongan.edit', compact('golongan'));
    }

    /**
     * Update data golongan di database.
     * - Cek nama golongan valid.
     * - Update data golongan.
     * - Balik ke halaman daftar golongan dengan pesan sukses.
     */
    public function update(Request $request, Golongan $golongan)
    {
        $request->validate(['nama_golongan' => 'required|string|max:255']);
        $golongan->update($request->only('nama_golongan'));
        return redirect()->route('golongan.index')->with('success', 'Golongan berhasil diperbarui.');
    }

    /**
     * Hapus golongan dari database.
     * - Hapus data golongan berdasarkan ID.
     * - Balik ke halaman daftar golongan dengan pesan sukses.
     */
    public function destroy(Golongan $golongan)
    {
        $golongan->delete();
        return redirect()->route('golongan.index')->with('success', 'Golongan berhasil dihapus.');
    }
}

