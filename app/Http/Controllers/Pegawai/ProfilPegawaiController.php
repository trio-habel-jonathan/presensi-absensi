<?php

namespace App\Http\Controllers\Pegawai;

// Controller utama dari Laravel
use App\Http\Controllers\Controller;

// Import semua model yang diperlukan
use App\Models\ProfilPegawai;
use App\Models\JenisPegawai;
use App\Models\Golongan;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfilPegawaiController extends Controller
{
    // Menampilkan daftar profil pegawai
    public function index()
    {
        // Ambil ID user yang sedang login
        $userId = auth()->user()->id_user;
    
        // Cari profil pegawai yang hanya milik user login
        $profilPegawai = ProfilPegawai::with(['jenisPegawai', 'golongan', 'user'])
                            ->where('id_user', $userId)
                            ->first();
    
        // Tampilkan halaman dengan data profil (jika ada)
        return view('pegawai.profil_pegawai.index', compact('profilPegawai'));
    }
    // Tampilkan form tambah data pegawai
    public function create()
    {
        // Tampilkan form create khusus pegawai (tanpa user & lainnya)
        return view('pegawai.profil_pegawai.create');
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

    ]);

    // Set otomatis user login
    $validated['id_user'] = Auth::user()->id_user;


    ProfilPegawai::create($validated);

    return redirect()->route('profil_pegawai.index')->with('success', 'Berhasil ditambahkan.');
}


    // Tampilkan form edit
    public function edit(ProfilPegawai $profilPegawai)
    {
        // Pastikan hanya user yang memiliki profil ini yang bisa mengedit
        if ($profilPegawai->id_user !== Auth::user()->id_user) {
            abort(403, 'Unauthorized action.');
        }

        return view('pegawai.profil_pegawai.edit', [
            'profilPegawai' => $profilPegawai,
        ]);
    }

    // Update data pegawai
    public function update(Request $request, ProfilPegawai $profilPegawai)
    {
        // Pastikan hanya user yang memiliki profil ini yang bisa mengupdate
        if ($profilPegawai->id_user !== Auth::user()->id_user) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input, cek juga agar no_identitas bisa sama selama itu milik data sekarang
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'no_identitas' => 'required|string|max:255|unique:profil_pegawai,no_identitas,' . $profilPegawai->id_profil_pegawai . ',id_profil_pegawai',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:255',
        ]);

        // Update data di database
        $validated['id_user'] = Auth::user()->id_user;

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
