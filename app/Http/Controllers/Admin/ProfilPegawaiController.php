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
    public function index(Request $request)
    {
        // Ambil query pencarian dari request
        $search = $request->input('search');

        // Ambil data profil pegawai dengan relasi, filter berdasarkan pencarian, lalu paginate 10 data per halaman
        $profilPegawais = ProfilPegawai::with(['jenisPegawai', 'golongan', 'user'])
            ->when($search, function ($query, $search) {
                // Filter data berdasarkan nama pegawai atau nomor identitas yang mengandung teks pencarian
                $query->where('nama_pegawai', 'like', "%{$search}%")
                      ->orWhere('no_identitas', 'like', "%{$search}%");
            })
            ->paginate(10); // Batasi hasil menjadi 10 data per halaman

        // Tampilkan view index dengan data profil pegawai dan query pencarian
        return view('admin.profil_pegawai.index', compact('profilPegawais', 'search'));
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
            'foto_pegawai' => 'nullable|file|mimes:jpg,png|max:2048', // Validasi untuk file foto
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

        // Jika ada file foto yang diunggah, simpan ke storage dan tambahkan path ke data
        if ($request->hasFile('foto_pegawai')) {
            $validated['foto_pegawai'] = $request->file('foto_pegawai')->store('foto_pegawai', 'public');
        }

        // Simpan data ke database
        ProfilPegawai::create($validated);

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('profil_pegawai.index')->with('success', 'Berhasil ditambahkan.');
    }

    // Tampilkan detail satu pegawai


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
            'foto_pegawai' => 'nullable|file|mimes:jpg,png|max:2048', // Validasi untuk file foto
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

        if ($request->hasFile('foto_pegawai')) {
            // Hapus foto lama jika ada
            if ($profilPegawai->foto_pegawai) {
                Storage::disk('public')->delete($profilPegawai->foto_pegawai);
            }
            $validated['foto_pegawai'] = $request->file('foto_pegawai')->store('foto_pegawai', 'public');
        } else {
            // Jika tidak ada foto baru, pertahankan foto lama
            $validated['foto_pegawai'] = $profilPegawai->foto_pegawai;
        }

        // Update data di database
        $profilPegawai->update($validated);

        return redirect()->route('profil_pegawai.index')->with('success', 'Berhasil diupdate.');
    }

    // Hapus data pegawai
    public function destroy(ProfilPegawai $profilPegawai)
    {
        // Hapus foto dari storage jika ada
        if ($profilPegawai->foto_pegawai) {
            Storage::disk('public')->delete($profilPegawai->foto_pegawai);
        }
        $profilPegawai->delete();
        return redirect()->route('profil_pegawai.index')->with('success', 'Berhasil dihapus.');
    }
}
