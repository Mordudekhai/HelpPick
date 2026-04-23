<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all();

        $penilaians = Penilaian::all()->keyBy(function ($item) {
            return $item->alternatif_id . '-' . $item->kriteria_id;
        });

        return view('penilaian.index', compact('alternatifs', 'kriterias', 'penilaians'));
    }

    public function store(Request $request)
    {
        foreach ($request->nilai as $alt_id => $kriteria) {
            foreach ($kriteria as $krit_id => $nilai) {

                if ($nilai === null || $nilai === '') {
                    return back()->with('error', 'Semua nilai harus diisi!');
                }

                Penilaian::updateOrCreate(
                    [
                        'alternatif_id' => $alt_id,
                        'kriteria_id' => $krit_id
                    ],
                    [
                        'nilai' => $nilai
                    ]
                );
            }
        }

        return back()->with('success', 'Penilaian berhasil disimpan');
    }
}