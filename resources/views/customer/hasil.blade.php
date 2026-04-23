@extends('layout.app')

@section('content')
<h3>Hasil Rekomendasi</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Ranking</th>
            <th>Nama Laptop</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        @php $rank = 1; @endphp
        @foreach($hasil as $id => $skor)
        <tr @if($rank==1) class="table-success" @endif>
            <td>{{ $rank }}</td>
            <td>{{ optional($alternatifs->find($id))->nama ?? '-' }}</td>
            <td>{{ round($skor, 4) }}</td>
        </tr>
        @php $rank++; @endphp
        @endforeach
    </tbody>
</table>

@php
$bestId = !empty($hasil) ? array_key_first($hasil) : null;
$bestLaptop = $bestId ? $alternatifs->find($bestId) : null;

$safeTopId = (!is_null($topKriteriaId) && isset($kontribusi[$topKriteriaId]))
? (int) $topKriteriaId
: null;

$topKriteria = $safeTopId ? $kriterias->find($safeTopId) : null;
@endphp

<div class="alert alert-info mt-4">
    <strong>Kesimpulan:</strong><br><br>

    @if($bestLaptop)
    Laptop terbaik adalah
    <b>{{ $bestLaptop->nama }}</b>
    karena memiliki skor tertinggi berdasarkan preferensi bobot yang Anda pilih.<br><br>
    @else
    Data hasil tidak tersedia.<br><br>
    @endif

    @if($topKriteria && $safeTopId !== null)
    <strong>Analisa:</strong><br>
    Kriteria <b>{{ $topKriteria->nama }}</b> memiliki pengaruh paling besar yaitu
    <b>{{ $kontribusi[$safeTopId] }}%</b> terhadap keputusan.<br>

    Hal ini menunjukkan bahwa faktor tersebut menjadi prioritas utama dalam menentukan pilihan laptop terbaik.
    @endif
</div>

<h5 class="mt-4">Rincian Tingkat Kepentingan Kriteria</h5>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Kriteria</th>
            <th>Pilihan Anda</th>
            <th>Skala</th>
            <th>Nilai Awal</th>
            <th>Bobot Normalisasi</th>
            <th>Kontribusi (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kriterias as $k)
        <tr>
            <td>{{ $k->nama }}</td>
            <td>{{ $detailBobot[$k->id]['label'] ?? '-' }}</td>
            <td>{{ $detailBobot[$k->id]['skala'] ?? '-' }}</td>
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

<div class="mt-4">
    <a href="{{ route('customer.form') }}" class="btn btn-secondary">
        ← Ubah Bobot & Hitung Ulang
    </a>
</div>

@endsection