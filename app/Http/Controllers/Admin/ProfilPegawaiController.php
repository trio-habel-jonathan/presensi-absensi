<?php

namespace App\Http\Controllers\Admin;

// Controller utama dari Laravel
use App\Http\Controllers\Controller;

// Import semua model yang diperlukan
use App\Models\ProfilPegawai;
use App\Models\JenisPegawai;
use App\Models\Golongan;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilPegawaiController extends Controller
{
    // Menampilkan daftar profil pegawai
    public function index()
    {
        // Ambil data profil pegawai beserta relasi jenis, golongan, dan user-nya, lalu paginate 10 data per halaman
        $profilPegawais = ProfilPegawai::with(['jenisPegawai', 'golongan', 'user'])->paginate(10);
        return view('admin.profil_pegawai.index', compact('profilPegawais'));
    }

    // Tampilkan form tambah data pegawai
    public function create()
    {
        return view('admin.profil_pegawai.create', [
            'jenisPegawais' => JenisPegawai::all(), // ambil semua jenis pegawai
            'golongans' => Golongan::all(),         // ambil semua golongan
            'users' => User::all(),                 // ambil semua user
        ]);
    }

    // Simpan data baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'no_identitas' => 'required|string|max:255|unique:profil_pegawai,no_identitas',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:255',
            'id_jenis_pegawai' => 'required|exists:jenis_pegawai,id_jenis_pegawai',
            'id_golongan' => 'required|exists:golongan,id_golongan',
            'id_user' => 'required|exists:users,id_user',
        ]);

        // Simpan data ke database
        ProfilPegawai::create($validated);

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('profil_pegawai.index')->with('success', 'Berhasil ditambahkan.');
    }

    // Tampilkan detail satu pegawai
    public function show(ProfilPegawai $profilPegawai)
    {
        // Load data relasi
        $profilPegawai->load(['jenisPegawai', 'golongan', 'user']);
        return view('admin.profil_pegawai.show', compact('profilPegawai'));
    }

    // Tampilkan form edit
    public function edit(ProfilPegawai $profilPegawai)
    {
        return view('admin.profil_pegawai.edit', [
            'profilPegawai' => $profilPegawai,
            'jenisPegawais' => JenisPegawai::all(),
            'golongans' => Golongan::all(),
            'users' => User::all(),
        ]);
    }

    // Update data pegawai
    public function update(Request $request, ProfilPegawai $profilPegawai)
    {
        // Validasi input, cek juga agar no_identitas bisa sama selama itu milik data sekarang
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'no_identitas' => 'required|string|max:255|unique:profil_pegawai,no_identitas,' . $profilPegawai->id_profil_pegawai . ',id_profil_pegawai',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:255',
            'id_jenis_pegawai' => 'required|exists:jenis_pegawai,id_jenis_pegawai',
            'id_golongan' => 'required|exists:golongan,id_golongan',
            'id_user' => 'required|exists:users,id_user',
        ]);

        // Update data di database
        $profilPegawai->update($validated);

        return redirect()->route('profil_pegawai.index')->with('success', 'Berhasil diupdate.');
    }

    // Hapus data pegawai
    public function destroy(ProfilPegawai $profilPegawai)
    {
        $profilPegawai->delete();
        return redirect()->route('profil_pegawai.index')->with('success', 'Berhasil dihapus.');
    }
}
