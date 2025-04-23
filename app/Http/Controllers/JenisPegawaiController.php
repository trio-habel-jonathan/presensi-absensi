<?php

namespace App\Http\Controllers;

use App\Models\JenisPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JenisPegawaiController extends Controller
{
    public function index()
    {
        $jenisPegawais = JenisPegawai::paginate(10);
        return view('jenis_pegawai.index', compact('jenisPegawais'));
    }

    public function create()
    {
        return view('jenis_pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis_pegawai' => 'required|string|max:255',
        ]);

        try {
            JenisPegawai::create($validated);
            return redirect()->route('jenis_pegawai.index')->with('success', 'Jenis Pegawai created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Jenis Pegawai: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create Jenis Pegawai.');
        }
    }

    public function show(JenisPegawai $jenisPegawai)
    {
        return view('jenis_pegawai.show', compact('jenisPegawai'));
    }

    public function edit(JenisPegawai $jenisPegawai)
    {
        return view('jenis_pegawai.edit', compact('jenisPegawai'));
    }

    public function update(Request $request, JenisPegawai $jenisPegawai)
    {
        $validated = $request->validate([
            'nama_jenis_pegawai' => 'required|string|max:255',
        ]);

        try {
            $jenisPegawai->update($validated);
            return redirect()->route('jenis_pegawai.index')->with('success', 'Jenis Pegawai updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Jenis Pegawai: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update Jenis Pegawai.');
        }
    }

    public function destroy(JenisPegawai $jenisPegawai)
    {
        try {
            $jenisPegawai->delete();
            return redirect()->route('jenis_pegawai.index')->with('success', 'Jenis Pegawai deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting Jenis Pegawai: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete Jenis Pegawai.');
        }
    }
}