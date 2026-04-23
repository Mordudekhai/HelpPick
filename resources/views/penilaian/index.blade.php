@extends('layout.admin')

@section('content')
<h3>Matrix Penilaian</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('penilaian.store') }}" method="POST">
    @csrf

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach($kriterias as $k)
                <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($alternatifs as $alt)
            <tr>
                <td>{{ $alt->nama }}</td>

                @foreach($kriterias as $k)
                @php $key = $alt->id . '-' . $k->id; @endphp

                <td>
                    <input type="number" step="0.01" name="nilai[{{ $alt->id }}][{{ $k->id }}]"
                        value="{{ $penilaians[$key]->nilai ?? '' }}" class="form-control" required>
                </td>
                @endforeach

            </tr>
            @endforeach
        </tbody>
    </table>

    <button class="btn btn-success">Simpan Penilaian</button>

</form>
@endsection