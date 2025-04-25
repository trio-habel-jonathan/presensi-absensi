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
        $userId = auth()->user()->id_user;
        $existingProfil = ProfilPegawai::where('id_user', $userId)->first();

        if ($existingProfil) {
            return redirect()->route('pegawai.profil.index')->with('warning', 'Anda sudah memiliki profil.');
        }

        return view('pegawai.profil_pegawai.create');
    }

    

    // Simpan data baru ke database
    public function store(Request $request)
{
    // Validasi input dari form
    $validated = $request->validate([
        'foto_pegawai' => 'required|file|mimes:jpg,png|max:2048', // Validasi untuk file foto
        'nama_pegawai' => 'required|string|max:255',
        'no_identitas' => 'required|string|max:255|unique:profil_pegawai,no_identitas',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:L,P',
        'alamat' => 'required|string|max:255',
        'no_telepon' => 'required|string|max:255',
        

    ]);

    if ($request->hasFile('foto_pegawai')) {
        $validated['foto_pegawai'] = $request->file('foto_pegawai')->store('foto_pegawai', 'public');
    }

    // Set otomatis user login
    $validated['id_user'] = Auth::user()->id_user;


    ProfilPegawai::create($validated);

    return redirect()->route('pegawai.profil.index')->with('success', 'Berhasil ditambahkan.');
}

}
