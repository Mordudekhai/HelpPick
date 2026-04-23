<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function form()
    {
        $kriterias = Kriteria::all();
        return view('customer.form', compact('kriterias'));
    }

    public function hitung(Request $request)
    {
        $inputBobot = $request->bobot;

        /*
        |--------------------------------------------------------------------------
        | STEP 1: VALIDASI INPUT
        |--------------------------------------------------------------------------
        */
        if (!$inputBobot || count($inputBobot) == 0) {
            return back()->with('error', 'Silakan pilih semua kriteria.');
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 2: MAPPING + LABEL
        |--------------------------------------------------------------------------
        */
        $mapping = [
            1 => 0.1,
            2 => 0.25,
            3 => 0.5,
            4 => 0.75,
            5 => 1
        ];

        $label = [
            1 => 'Tidak Terlalu Penting',
            2 => 'Kurang Penting',
            3 => 'Cukup Penting',
            4 => 'Penting',
            5 => 'Sangat Penting'
        ];

        $bobot = [];
        $detailBobot = [];

        foreach ($inputBobot as $key => $val) {

            if (!isset($mapping[$val])) {
                return back()->with('error', 'Input bobot tidak valid.');
            }

            $nilai = $mapping[$val];

            $bobot[$key] = $nilai;

            $detailBobot[$key] = [
                'skala' => $val,
                'label' => $label[$val],
                'nilai_awal' => $nilai
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 3: NORMALISASI BOBOT
        |--------------------------------------------------------------------------
        */
        $total = array_sum($bobot);

        if ($total == 0) {
            return back()->with('error', 'Bobot tidak valid.');
        }

        foreach ($bobot as $k => $v) {
            $normalized = $v / $total;

            $bobot[$k] = $normalized;
            $detailBobot[$k]['normalisasi'] = $normalized;
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 4: AMBIL DATA
        |--------------------------------------------------------------------------
        */
        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::all();
        $penilaians = Penilaian::all();

        if ($kriterias->isEmpty() || $alternatifs->isEmpty()) {
            return back()->with('error', 'Data alternatif atau kriteria belum lengkap.');
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 5: MATRIX
        |--------------------------------------------------------------------------
        */
        $matrix = [];

        foreach ($penilaians as $p) {
            $matrix[$p->alternatif_id][$p->kriteria_id] = $p->nilai;
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 6: NORMALISASI SAW
        |--------------------------------------------------------------------------
        */
        $normalisasi = [];

        foreach ($kriterias as $k) {
            $values = [];

            foreach ($alternatifs as $alt) {
                if (!isset($matrix[$alt->id][$k->id])) {
                    continue;
                }
                $values[] = $matrix[$alt->id][$k->id];
            }

            if (empty($values)) continue;

            $max = max($values);
            $min = min($values);

            foreach ($alternatifs as $alt) {

                if (!isset($matrix[$alt->id][$k->id])) continue;

                $nilai = $matrix[$alt->id][$k->id];

                if ($k->tipe == 'benefit') {
                    $normalisasi[$alt->id][$k->id] = $nilai / $max;
                } else {
                    $normalisasi[$alt->id][$k->id] = $min / $nilai;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 7: HITUNG SKOR
        |--------------------------------------------------------------------------
        */
        $hasil = [];

        foreach ($alternatifs as $alt) {
            $skor = 0;

            foreach ($kriterias as $k) {
                if (!isset($normalisasi[$alt->id][$k->id])) continue;

                $skor += $bobot[$k->id] * $normalisasi[$alt->id][$k->id];
            }

            $hasil[$alt->id] = $skor;
        }

        arsort($hasil);

        /*
        |--------------------------------------------------------------------------
        | STEP 8: KONTRIBUSI (%)
        |--------------------------------------------------------------------------
        */
        $kontribusi = [];

        foreach ($kriterias as $k) {
            $kontribusi[$k->id] = isset($bobot[$k->id])
                ? round($bobot[$k->id] * 100, 2)
                : 0;
        }

        $topKriteriaId = null;

        if (!empty($kontribusi)) {
            arsort($kontribusi);
            $topKriteriaId = array_key_first($kontribusi);
        }

        return view('customer.hasil', compact(
            'hasil',
            'alternatifs',
            'kriterias',
            'detailBobot',
            'kontribusi',
            'topKriteriaId'
        ));
    }
}