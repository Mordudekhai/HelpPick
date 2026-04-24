<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
    =========================
    DASHBOARD
    =========================
    */
    public function dashboard()
    {
        /*
        =========================
        AMBIL DATA
        =========================
        */
        $alternatifs = Alternatif::all();
        $kriterias   = Kriteria::all();
        $penilaians  = Penilaian::all();

        /*
        =========================
        MATRIX NILAI
        =========================
        */
        $matrix = [];

        foreach ($penilaians as $p) {
            $matrix[$p->alternatif_id][$p->kriteria_id] = $p->nilai;
        }

        /*
        =========================
        🔥 SIMPLE SCORING
        (UNTUK WIDGET DASHBOARD)
        =========================
        */
        $hasil = [];

        foreach ($alternatifs as $alt) {

            $total = 0;
            $count = 0;

            foreach ($kriterias as $k) {

                if (isset($matrix[$alt->id][$k->id])) {
                    $total += (float)$matrix[$alt->id][$k->id];
                    $count++;
                }
            }

            /*
            =========================
            RATA-RATA NILAI
            =========================
            */
            $hasil[$alt->id] = $count > 0
                ? $total / $count
                : 0;
        }

        /*
        =========================
        SORT DESC (TERBAIK ATAS)
        =========================
        */
        arsort($hasil);

        /*
        =========================
        RETURN VIEW
        =========================
        */
        return view('admin.dashboard', compact(
            'alternatifs',
            'kriterias',
            'penilaians',
            'matrix',
            'hasil'
        ));
    }
}