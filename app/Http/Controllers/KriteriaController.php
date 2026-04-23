<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $data = Kriteria::latest()->get();
        return view('kriteria.index', compact('data'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required|in:benefit,cost',
        ]);

        Kriteria::create([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'bobot' => 0 // default saja (tidak dipakai)
        ]);

        return redirect()->route('kriteria.index')->with('success', 'Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Kriteria::findOrFail($id);
        return view('kriteria.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required|in:benefit,cost',
        ]);

        $data = Kriteria::findOrFail($id);

        $data->update([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('kriteria.index')->with('success', 'Berhasil diupdate');
    }

    public function destroy($id)
    {
        Kriteria::findOrFail($id)->delete();
        return back()->with('success', 'Berhasil dihapus');
    }
}