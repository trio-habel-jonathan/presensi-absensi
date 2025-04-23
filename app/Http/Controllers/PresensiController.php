<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\ProfilPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PresensiController extends Controller
{
    public function index()
    {
        $presensis = Presensi::with('profilPegawai')->paginate(10);
        return view('admin.presensi.index', compact('presensis'));
    }

    public function create()
    {
        $profilPegawais = ProfilPegawai::all();
        return view('admin.presensi.create', compact('profilPegawais'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_profil_pegawai' => 'required|exists:profil_pegawai,id_profil_pegawai',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'foto_masuk' => 'required|file|mimes:jpg,png|max:2048',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,terlambat,izin,cuti',
            'catatan' => 'nullable|string',
        ]);

        try {
            if ($request->hasFile('foto_masuk')) {
                $validated['foto_masuk'] = $request->file('foto_masuk')->store('photos', 'public');
            }
            Presensi::create($validated);
            return redirect()->route('presensi.index')->with('success', 'Presensi created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Presensi: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create Presensi.');
        }
    }

    public function show(Presensi $presensi)
    {
        $presensi->load('profilPegawai');
        return view('admin.presensi.show', compact('presensi'));
    }

    public function edit(Presensi $presensi)
    {
        $profilPegawais = ProfilPegawai::all();
        return view('admin.presensi.edit', compact('presensi', 'profilPegawais'));
    }

    public function update(Request $request, Presensi $presensi)
    {
        $validated = $request->validate([
            'id_profil_pegawai' => 'required|exists:profil_pegawai,id_profil_pegawai',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'foto_masuk' => 'nullable|file|mimes:jpg,png|max:2048',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,terlambat,izin,cuti',
            'catatan' => 'nullable|string',
        ]);

        try {
            if ($request->hasFile('foto_masuk')) {
                $validated['foto_masuk'] = $request->file('foto_masuk')->store('photos', 'public');
            } else {
                $validated['foto_masuk'] = $presensi->foto_masuk;
            }
            $presensi->update($validated);
            return redirect()->route('presensi.index')->with('success', 'Presensi updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Presensi: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update Presensi.');
        }
    }

    public function destroy(Presensi $presensi)
    {
        try {
            $presensi->delete();
            return redirect()->route('presensi.index')->with('success', 'Presensi deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting Presensi: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete Presensi.');
        }
    }
}