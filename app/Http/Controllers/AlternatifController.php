<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        $data = Alternatif::orderByRaw('CAST(SUBSTRING(kode, 2) AS UNSIGNED) ASC')
            ->paginate(10); // 🔥 FIX

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

        // AUTO GENERATE KODE (AMAN)
        $last = Alternatif::orderByRaw('CAST(SUBSTRING(kode, 2) AS UNSIGNED) DESC')->first();

        if ($last && $last->kode) {
            $lastNumber = (int) str_replace('A', '', $last->kode);
            $newKode = 'A' . ($lastNumber + 1);
        } else {
            $newKode = 'A1';
        }

        Alternatif::create([
            'kode' => $newKode,
            'nama' => $request->nama
        ]);

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

        $data->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Alternatif::findOrFail($id)->delete();

        return redirect()->route('alternatif.index')->with('success', 'Data berhasil dihapus');
    }
}