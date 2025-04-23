<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\ProfilPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IzinController extends Controller
{
    public function index()
    {
        $izins = Izin::with('profilPegawai')->paginate(10);
        return view('admin.izin.index', compact('izins'));
    }

    public function create()
    {
        $profilPegawais = ProfilPegawai::all();
        return view('admin.izin.create', compact('profilPegawais'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_profil_pegawai' => 'required|exists:profil_pegawai,id_profil_pegawai',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:sakit,cuti,izin',
            'keterangan' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        try {
            if ($request->hasFile('lampiran')) {
                $validated['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
            }
            Izin::create($validated);
            return redirect()->route('izin.index')->with('success', 'Izin created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Izin: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create Izin.');
        }
    }

    public function show(Izin $izin)
    {
        $izin->load('profilPegawai');
        return view('admin.izin.show', compact('izin'));
    }

    public function edit(Izin $izin)
    {
        $profilPegawais = ProfilPegawai::all();
        return view('admin.izin.edit', compact('izin', 'profilPegawais'));
    }

    public function update(Request $request, Izin $izin)
    {
        $validated = $request->validate([
            'id_profil_pegawai' => 'required|exists:profil_pegawai,id_profil_pegawai',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:sakit,cuti,izin',
            'keterangan' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        try {
            if ($request->hasFile('lampiran')) {
                $validated['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
            } else {
                $validated['lampiran'] = $izin->lampiran;
            }
            $izin->update($validated);
            return redirect()->route('izin.index')->with('success', 'Izin updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Izin: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update Izin.');
        }
    }

    public function destroy(Izin $izin)
    {
        try {
            $izin->delete();
            return redirect()->route('izin.index')->with('success', 'Izin deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting Izin: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete Izin.');
        }
    }
}