<?php

namespace App\Http\Controllers;

use App\Models\ProfilPegawai;
use App\Models\JenisPegawai;
use App\Models\Golongan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfilPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profilPegawais = ProfilPegawai::with(['jenisPegawai', 'golongan', 'user'])->paginate(10);
        return view('profil_pegawai.index', compact('profilPegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisPegawais = JenisPegawai::all();
        $golongans = Golongan::all();
        $users = User::all();
        return view('profil_pegawai.create', compact('jenisPegawais', 'golongans', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

        try {
            ProfilPegawai::create($validated);
            return redirect()->route('profil_pegawai.index')->with('success', 'Profil Pegawai created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Profil Pegawai: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create Profil Pegawai.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfilPegawai $profilPegawai)
    {
        $profilPegawai->load(['jenisPegawai', 'golongan', 'user']);
        return view('profil_pegawai.show', compact('profilPegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfilPegawai $profilPegawai)
    {
        $jenisPegawais = JenisPegawai::all();
        $golongans = Golongan::all();
        $users = User::all();
        return view('profil_pegawai.edit', compact('profilPegawai', 'jenisPegawais', 'golongans', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfilPegawai $profilPegawai)
    {
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

        try {
            $profilPegawai->update($validated);
            return redirect()->route('profil_pegawai.index')->with('success', 'Profil Pegawai updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Profil Pegawai: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update Profil Pegawai.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfilPegawai $profilPegawai)
    {
        try {
            $profilPegawai->delete();
            return redirect()->route('profil_pegawai.index')->with('success', 'Profil Pegawai deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting Profil Pegawai: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete Profil Pegawai.');
        }
    }
}