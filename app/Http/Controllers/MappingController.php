<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::orderByRaw('CAST(SUBSTRING(kode, 2) AS UNSIGNED) ASC')->get();

        $kriterias = Kriteria::with('parameters')->get();

        $penilaians = Penilaian::all()->keyBy(function ($item) {
            return $item->alternatif_id . '-' . $item->kriteria_id;
        });

        return view('mapping.index', compact('alternatifs', 'kriterias', 'penilaians'));
    }

    public function store(Request $request)
    {
        foreach ($request->nilai as $alt_id => $kriteria) {
            foreach ($kriteria as $krit_id => $score) {

                if ($score === null || $score === '') continue;

                Penilaian::updateOrCreate(
                    [
                        'alternatif_id' => $alt_id,
                        'kriteria_id' => $krit_id
                    ],
                    [
                        'nilai' => $score
                    ]
                );
            }
        }

        return back()->with('success', 'Mapping berhasil disimpan');
    }
}