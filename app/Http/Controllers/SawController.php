<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Hasil;

class SawController extends Controller
{
    public function hitung()
    {
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::all();

        // VALIDASI
        foreach ($alternatifs as $alt) {
            $count = $penilaians->where('alternatif_id', $alt->id)->count();
            if ($count != $kriterias->count()) {
                return back()->with('error', 'Penilaian belum lengkap!');
            }
        }

        // MATRIX NILAI
        $matrix = [];
        foreach ($penilaians as $p) {
            $matrix[$p->alternatif_id][$p->kriteria_id] = $p->nilai;
        }

        // NORMALISASI
        $normalisasi = [];

        foreach ($kriterias as $k) {
            $values = [];

            foreach ($alternatifs as $alt) {
                $values[] = $matrix[$alt->id][$k->id];
            }

            $max = max($values);
            $min = min($values);

            foreach ($alternatifs as $alt) {
                $nilai = $matrix[$alt->id][$k->id];

                if ($k->tipe == 'benefit') {
                    $normalisasi[$alt->id][$k->id] = $nilai / $max;
                } else {
                    $normalisasi[$alt->id][$k->id] = $min / $nilai;
                }
            }
        }

        // HITUNG SKOR
        $hasil = [];

        foreach ($alternatifs as $alt) {
            $skor = 0;

            foreach ($kriterias as $k) {
                $skor += $k->bobot * $normalisasi[$alt->id][$k->id];
            }

            $hasil[$alt->id] = $skor;
        }

        // SORTING
        arsort($hasil);

        // SIMPAN HASIL
        Hasil::truncate();

        $ranking = 1;

        foreach ($hasil as $alt_id => $skor) {
            Hasil::create([
                'alternatif_id' => $alt_id,
                'skor' => $skor,
                'ranking' => $ranking++
            ]);
        }

        return redirect()->route('hasil.index')->with('success', 'Perhitungan SAW selesai');
    }

    public function index()
    {
        $hasils = Hasil::with('alternatif')->orderBy('ranking')->get();
        return view('hasil.index', compact('hasils'));
    }
}