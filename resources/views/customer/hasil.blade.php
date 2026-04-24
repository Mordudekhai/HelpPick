@extends('layout.app')

@section('content')

<style>
.btn-modern-secondary {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #fff;
    padding: 12px;
    border-radius: 12px;
    text-decoration: none;
    transition: 0.25s;
    display: block;
    text-align: center;
}

.btn-modern-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.2);
    color: #fff;
}

.table-modern {
    width: 100%;
    border-collapse: collapse;
}

.table-modern th,
.table-modern td {
    border: 1px solid #e5e7eb;
    padding: 10px;
    text-align: center;
}

.table-modern th {
    background: #f1f5f9;
}

.nama-cell {
    text-align: left;
}

.kode-cell {
    font-weight: bold;
}
</style>

<div class="card-modern">

    <h4 class="mb-4">Hasil Rekomendasi</h4>

    {{-- ========================
       HANDLE DATA KOSONG
    ======================== --}}
    @if(empty($hasil) || count($hasil) == 0)

    <div class="alert alert-warning">
        Data hasil tidak tersedia. Silakan ulangi proses.
    </div>

    @else

    {{-- ========================
       TABEL RANKING
    ======================== --}}
    <table class="table-modern mb-4">

        <thead>
            <tr>
                <th style="width:80px;">Rank</th>
                <th>Alternatif</th>
                <th style="width:150px;">Skor</th>
            </tr>
        </thead>

        <tbody>
            @php $rank = 1; @endphp

            @foreach($hasil as $id => $skor)
            <tr @if($rank==1) style="background:#ecfdf5;" @endif>

                <td class="kode-cell">{{ $rank }}</td>

                <td class="nama-cell">
                    {{ optional($alternatifs->find($id))->nama ?? '-' }}
                </td>

                <td><strong>{{ round($skor, 4) }}</strong></td>

            </tr>

            @php $rank++; @endphp
            @endforeach
        </tbody>

    </table>

    @endif

    @php
    $bestId = !empty($hasil) ? array_key_first($hasil) : null;

    $sorted = $kontribusi;
    arsort($sorted);
    $topKriteriaKeys = array_slice(array_keys($sorted), 0, 3);
    @endphp

    {{-- ========================
       KESIMPULAN
    ======================== --}}
    <div class="alert alert-info">

        <strong>Kesimpulan:</strong><br><br>

        @if($bestId)
        Alternatif terbaik adalah
        <b>{{ optional($alternatifs->find($bestId))->nama }}</b>.<br><br>
        @endif

        <strong>
            Berdasarkan preferensi yang Anda pilih, kriteria berikut memiliki pengaruh paling besar dalam menentukan
            hasil:
        </strong><br>

        @foreach($topKriteriaKeys as $kid)
        @php $k = $kriterias->find($kid); @endphp
        • {{ $k->nama }} → <b>{{ $kontribusi[$kid] }}%</b><br>
        @endforeach

        <strong>
            Hal ini menunjukkan bahwa kriteria tersebut menjadi faktor utama dalam proses rekomendasi.
        </strong>

    </div>

    {{-- ========================
       🔥 PREFERENSI USER (BARU)
    ======================== --}}
    <h5 class="mt-4 mb-3">Rincian Alternatif <strong>{{ optional($alternatifs->find($bestId))->nama }}</strong>
    </h5>

    <table class="table-modern mb-4">
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Pilihan</th>
                <th>Detail Range</th>
            </tr>
        </thead>

        <tbody>
            @foreach($kriterias as $k)

            @php $d = $detailBobot[$k->id] ?? null; @endphp

            <tr>
                <td class="nama-cell">{{ $k->nama }}</td>

                <td>{{ $d['label'] ?? '-' }}</td>

                <td>
                    @php $range = $detailRange[$k->id] ?? null; @endphp

                    @if($range && ($range['min'] || $range['max']))
                    {{ $range['min'] ?? '0' }} - {{ $range['max'] ?? '∞' }}
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>

    {{-- ========================
       TABEL PERBANDINGAN
    ======================== --}}
    @if(isset($matrix))

    <h5 class="mt-4 mb-3">Perbandingan Nilai Alternatif</h5>

    <div style="overflow-x:auto;">
        <table class="table-modern">

            <thead>
                <tr>
                    <th>Alternatif</th>

                    @foreach($kriterias as $k)
                    <th @if(in_array($k->id, $topKriteriaKeys))
                        style="background:#dbeafe; font-weight:600;"
                        @endif>
                        {{ $k->nama }}
                    </th>
                    @endforeach

                </tr>
            </thead>

            <tbody>

                @foreach($alternatifs as $alt)
                <tr @if($alt->id == $bestId)
                    style="background:#ecfdf5; font-weight:600;"
                    @endif>

                    <td class="nama-cell">
                        {{ $alt->nama }}
                        @if($alt->id == $bestId) ⭐ @endif
                    </td>

                    @foreach($kriterias as $k)

                    @php
                    $nilai = $matrix[$alt->id][$k->id] ?? null;
                    @endphp

                    <td @if($alt->id == $bestId && in_array($k->id, $topKriteriaKeys))
                        style="background:#bbf7d0; font-weight:700;"
                        @elseif(in_array($k->id, $topKriteriaKeys))
                        style="background:#e0f2fe;"
                        @endif>
                        {{ $nilai ?? '-' }}
                    </td>

                    @endforeach

                </tr>
                @endforeach

            </tbody>

        </table>
    </div>

    @endif

    {{-- ========================
       DETAIL PERHITUNGAN
    ======================== --}}
    <h5 class="mt-4 mb-3">Rincian Perhitungan</h5>

    <table class="table-modern">

        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Pilihan</th>
                <th>Nilai</th>
                <th>Normalisasi</th>
                <th>Kontribusi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($kriterias as $k)
            <tr>

                <td class="nama-cell">{{ $k->nama }}</td>

                <td>{{ $detailBobot[$k->id]['label'] ?? '-' }}</td>

                <td>{{ $detailBobot[$k->id]['nilai_awal'] ?? '-' }}</td>

                <td>
                    {{ isset($detailBobot[$k->id]['normalisasi']) 
                        ? round($detailBobot[$k->id]['normalisasi'], 4) 
                        : '-' }}
                </td>

                <td>{{ $kontribusi[$k->id] ?? 0 }}%</td>

            </tr>
            @endforeach
        </tbody>

    </table>

    {{-- BUTTON --}}
    <div class="mt-4">
        <a href="{{ route('customer.form') }}" class="btn-modern-secondary w-100 mt-3 mb-4">
            ← Ubah Preferensi
        </a>
    </div>

</div>

@endsection