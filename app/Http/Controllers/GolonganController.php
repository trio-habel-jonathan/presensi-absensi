<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GolonganController extends Controller
{
    public function index()
    {
        $golongans = Golongan::paginate(10);
        return view('golongan.index', compact('golongans'));
    }

    public function create()
    {
        return view('golongan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_golongan' => 'required|string|max:255',
        ]);

        try {
            Golongan::create($validated);
            return redirect()->route('golongan.index')->with('success', 'Golongan created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Golongan: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create Golongan.');
        }
    }

    public function show(Golongan $golongan)
    {
        return view('golongan.show', compact('golongan'));
    }

    public function edit(Golongan $golongan)
    {
        return view('golongan.edit', compact('golongan'));
    }

    public function update(Request $request, Golongan $golongan)
    {
        $validated = $request->validate([
            'nama_golongan' => 'required|string|max:255',
        ]);

        try {
            $golongan->update($validated);
            return redirect()->route('golongan.index')->with('success', 'Golongan updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Golongan: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update Golongan.');
        }
    }

    public function destroy(Golongan $golongan)
    {
        try {
            $golongan->delete();
            return redirect()->route('golongan.index')->with('success', 'Golongan deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting Golongan: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete Golongan.');
        }
    }
}