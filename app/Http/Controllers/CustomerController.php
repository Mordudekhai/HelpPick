<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\KriteriaParameter;
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
        /*
        =========================
        INPUT BOBOT (WAJIB SAW)
        =========================
        */
        $inputBobot = $request->bobot;

        if (!$inputBobot || count($inputBobot) == 0) {
            return back()->with('error', 'Silakan isi bobot semua kriteria.');
        }

        /*
        =========================
        KONVERSI SKALA → NILAI
        =========================
        */
        $mapping = [
            1 => 0.1,
            2 => 0.25,
            3 => 0.5,
            4 => 0.75,
            5 => 1
        ];

        $label = [
            1 => 'Tidak Penting',
            2 => 'Kurang Penting',
            3 => 'Cukup Penting',
            4 => 'Penting',
            5 => 'Sangat Penting'
        ];

        $bobot = [];
        $detailBobot = [];

        foreach ($inputBobot as $kriteria_id => $val) {

            if (!isset($mapping[$val])) {
                return back()->with('error', 'Input bobot tidak valid.');
            }

            $nilai = $mapping[$val];

            $bobot[$kriteria_id] = $nilai;

            $detailBobot[$kriteria_id] = [
                'skala' => $val,
                'label' => $label[$val],
                'nilai_awal' => $nilai
            ];
        }

        /*
        =========================
        NORMALISASI BOBOT
        =========================
        */
        $total = array_sum($bobot);

        foreach ($bobot as $k => $v) {
            $normalized = $v / $total;
            $bobot[$k] = $normalized;
            $detailBobot[$k]['normalisasi'] = $normalized;
        }

        /*
        =========================
        AMBIL DATA
        =========================
        */
        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::all();
        $penilaians = Penilaian::all();

        /*
        =========================
        MATRIX
        =========================
        */
        $matrix = [];

        foreach ($penilaians as $p) {
            $matrix[$p->alternatif_id][$p->kriteria_id] = $p->nilai;
        }

        /*
        =========================
        NORMALISASI SAW
        =========================
        */
        $normalisasi = [];

        foreach ($kriterias as $k) {

            $values = [];

            foreach ($alternatifs as $alt) {
                if (isset($matrix[$alt->id][$k->id])) {
                    $values[] = $matrix[$alt->id][$k->id];
                }
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
        =========================
        HITUNG SKOR SAW
        =========================
        */
        $hasil = [];

        foreach ($alternatifs as $alt) {

            $skor = 0;

            foreach ($kriterias as $k) {
                if (isset($normalisasi[$alt->id][$k->id])) {
                    $skor += $bobot[$k->id] * $normalisasi[$alt->id][$k->id];
                }
            }

            $hasil[$alt->id] = $skor;
        }

        arsort($hasil);

        /*
        =========================
        🔥 AMBIL PEMENANG
        =========================
        */
        $bestId = array_key_first($hasil);

        /*
        =========================
        🔥 AMBIL RANGE PARAMETER DARI PEMENANG
        =========================
        */
        $detailRange = [];

        foreach ($kriterias as $k) {

            $nilai = $matrix[$bestId][$k->id] ?? null;

            if ($nilai === null) {
                $detailRange[$k->id] = null;
                continue;
            }

            $param = KriteriaParameter::where('kriteria_id', $k->id)
                ->where('score', $nilai)
                ->first();

            if ($param) {
                $detailRange[$k->id] = [
                    'min' => $param->min_value,
                    'max' => $param->max_value,
                    'label' => $param->label
                ];
            } else {
                $detailRange[$k->id] = null;
            }
        }

        /*
        =========================
        KONTRIBUSI
        =========================
        */
        $kontribusi = [];

        foreach ($kriterias as $k) {
            $kontribusi[$k->id] = round($bobot[$k->id] * 100, 2);
        }

        $sorted = $kontribusi;
        arsort($sorted);
        $topKriterias = array_slice($sorted, 0, 3, true);

        return view('customer.hasil', compact(
            'hasil',
            'alternatifs',
            'kriterias',
            'detailBobot',
            'kontribusi',
            'topKriterias',
            'matrix',
            'detailRange'
        ));
    }
}