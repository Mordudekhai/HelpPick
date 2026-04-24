<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\KriteriaParameter;
use Illuminate\Http\Request;

class KriteriaParameterController extends Controller
{
    public function index($kriteria_id)
    {
        $kriteria = Kriteria::findOrFail($kriteria_id);

        // 🔥 ambil & urutkan biar rapi
        $parameters = $kriteria->parameters()->orderBy('score', 'asc')->get();

        return view('kriteria.parameter', compact('kriteria', 'parameters'));
    }

    public function store(Request $request, $kriteria_id)
    {
        /*
        =====================================
        VALIDASI DASAR (TIDAK MERUSAK FLOW)
        =====================================
        */
        if (!$request->label || count($request->label) == 0) {
            return back()->with('error', 'Data parameter kosong');
        }

        /*
        =====================================
        🔥 FIX UTAMA: HAPUS DATA LAMA
        (AGAR TIDAK DUPLIKAT & BISA UPDATE)
        =====================================
        */
        KriteriaParameter::where('kriteria_id', $kriteria_id)->delete();

        /*
        =====================================
        INSERT ULANG (MODE UPDATE)
        =====================================
        */
        foreach ($request->label as $i => $label) {

            if (!$label) continue; // skip kosong

            KriteriaParameter::create([
                'kriteria_id' => $kriteria_id,
                'label'       => $label,
                'min_value'   => $request->min[$i] ?? null,
                'max_value'   => $request->max[$i] ?? null,
                'score'       => $request->score[$i] ?? 0,
            ]);
        }

        return back()->with('success', 'Parameter berhasil diupdate');
    }

    public function destroy($id)
    {
        KriteriaParameter::findOrFail($id)->delete();

        return back()->with('success', 'Parameter dihapus');
    }
}