<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        $data = Alternatif::latest()->get();
        return view('alternatif.index', compact('data'));
    }

    public function create()
    {
        return view('alternatif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Alternatif::create($request->only('nama'));

        return redirect()->route('alternatif.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Alternatif::findOrFail($id);
        return view('alternatif.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $data = Alternatif::findOrFail($id);
        $data->update($request->only('nama'));

        return redirect()->route('alternatif.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Alternatif::findOrFail($id)->delete();
        return redirect()->route('alternatif.index')->with('success', 'Data berhasil dihapus');
    }
}