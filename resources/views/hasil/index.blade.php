@extends('layout.app')

@section('content')
<h3>Hasil SPK (SAW)</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('saw.hitung') }}" class="btn btn-primary mb-3">
    Hitung SPK
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Ranking</th>
            <th>Nama Laptop</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hasils as $h)
        <tr @if($h->ranking == 1) class="table-success" @endif>
            <td>{{ $h->ranking }}</td>
            <td>{{ $h->alternatif->nama }}</td>
            <td>{{ round($h->skor, 4) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection