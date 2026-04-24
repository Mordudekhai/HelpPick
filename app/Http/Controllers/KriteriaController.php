<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Penilaian; // 🔥 TAMBAH INI
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $data = Kriteria::orderByRaw('CAST(SUBSTRING(kode, 2) AS UNSIGNED) ASC')
            ->paginate(10);

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

        $last = Kriteria::orderByRaw('CAST(SUBSTRING(kode, 2) AS UNSIGNED) DESC')->first();

        if ($last && $last->kode) {
            $lastNumber = (int) str_replace('C', '', $last->kode);
            $newKode = 'C' . ($lastNumber + 1);
        } else {
            $newKode = 'C1';
        }

        Kriteria::create([
            'kode' => $newKode,
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'bobot' => 0
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
        $kriteria = Kriteria::findOrFail($id);

        // 🔥 PENTING: hapus semua penilaian terkait
        Penilaian::where('kriteria_id', $kriteria->id)->delete();

        // 🔥 baru hapus kriteria
        $kriteria->delete();

        return redirect()->route('kriteria.index')->with('success', 'Berhasil dihapus');
    }
}