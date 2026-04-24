@extends('layout.admin')

@section('content')

<style>
/* =========================
   🔥 FIX KHUSUS DASHBOARD
   (VERTICAL SCROLL AKTIF)
========================= */
.content-body {
    overflow-y: auto !important;
}

.card-modern {
    overflow: visible !important;
}

/* =========================
   OPTIONAL: BIAR LEBIH ENAK
========================= */
.table-page {
    padding-bottom: 40px;
}

/* =========================
   FIX ALIGNMENT KOLOM
========================= */
.table-modern td,
.table-modern th {
    text-align: center;
}

/* KHUSUS KOLOM NAMA */
.table-modern td.nama-cell {
    text-align: left !important;
}
</style>


<div class="table-page">

    <h4 class="mb-3">Dashboard Admin</h4>

    {{-- =========================
       WIDGET RINGKASAN
    ========================= --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card p-3">
                <div class="fw-semibold">Total Alternatif</div>
                <h4>{{ $alternatifs->count() }}</h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <div class="fw-semibold">Total Kriteria</div>
                <h4>{{ $kriterias->count() }}</h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <div class="fw-semibold">Total Penilaian</div>
                <h4>{{ $penilaians->count() }}</h4>
            </div>
        </div>

    </div>

    {{-- =========================
       TABEL NILAI ALTERNATIF
    ========================= --}}
    <div class="table-area mb-4">

        <h5 class="mb-3">Data Nilai Alternatif</h5>

        <div class="table-scroll">
            <table class="table-modern">

                <thead>
                    <tr>
                        <th style="min-width:200px;">Alternatif</th>

                        @foreach($kriterias as $k)
                        <th style="min-width:140px;">{{ $k->nama }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @forelse($alternatifs as $alt)
                    <tr>

                        <td class="nama-cell">
                            {{ $alt->nama }}
                        </td>

                        @foreach($kriterias as $k)
                        <td>
                            {{ $matrix[$alt->id][$k->id] ?? '-' }}
                        </td>
                        @endforeach

                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $kriterias->count() + 1 }}" class="text-center">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- =========================
       PERBANDINGAN SKOR
    ========================= --}}
    <div class="table-area">

        <h5 class="mb-3">Perbandingan Skor Alternatif</h5>

        <div class="table-scroll">

            <table class="table-modern">

                <thead>
                    <tr>
                        <th style="min-width:200px;">Alternatif</th>
                        <th style="width:120px;">Skor</th>
                        <th style="min-width:250px;">Visual</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                    $maxScore = !empty($hasil) ? max($hasil) : 1;
                    @endphp

                    @forelse($hasil as $id => $score)

                    @php
                    $alt = $alternatifs->find($id);
                    $percent = $maxScore > 0 ? ($score / $maxScore) * 100 : 0;
                    @endphp

                    <tr>

                        <td class="nama-cell">
                            {{ $alt->nama ?? '-' }}
                        </td>

                        <td>
                            <strong>{{ round($score, 4) }}</strong>
                        </td>

                        <td>
                            <div style="background:#e5e7eb; border-radius:6px;">
                                <div style="
                                    width: {{ $percent }}%;
                                    height:10px;
                                    border-radius:6px;
                                    background: linear-gradient(90deg, #2563eb, #60a5fa);
                                ">
                                </div>
                            </div>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            Tidak ada data skor
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection