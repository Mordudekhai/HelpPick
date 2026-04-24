@extends('layout.admin')

@section('content')

<h3 class="mb-4">Matrix Penilaian</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- 🔥 INFO SKALA --}}
<div class="alert alert-info">
    Gunakan skala <strong>1 - 6</strong><br>
    1 = Sangat Rendah / Tidak Baik<br>
    6 = Sangat Tinggi / Sangat Baik
</div>

<form action="{{ route('penilaian.store') }}" method="POST">
    @csrf

    <div class="table-wrapper">

        <div class="table-scroll">
            <table class="table-modern">

                <thead>
                    <tr>
                        <th style="width:80px;"></th>
                        <th style="min-width:220px;"></th>

                        @foreach($kriterias as $k)
                        <th class="kriteria-col">{{ $k->kode }}</th>
                        @endforeach
                    </tr>

                    <tr>
                        <th></th>
                        <th>Alternatif</th>

                        @foreach($kriterias as $k)
                        <th class="kriteria-col">{{ $k->nama }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($alternatifs as $alt)
                    <tr>

                        <td class="kode-cell">
                            {{ $alt->kode ?? '-' }}
                        </td>

                        <td class="nama-cell">
                            {{ $alt->nama }}
                        </td>

                        @foreach($kriterias as $k)
                        @php $key = $alt->id . '-' . $k->id; @endphp

                        <td>
                            <input type="number" name="nilai[{{ $alt->id }}][{{ $k->id }}]"
                                value="{{ $penilaians[$key]->nilai ?? '' }}" class="form-control input-nilai" min="1"
                                max="6" step="1" required>
                        </td>

                        @endforeach

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

    <button class="btn btn-success mt-3">
        Simpan Penilaian
    </button>

</form>

{{-- PAGINATION --}}
<div class="table-footer">
    <!-- {{ $alternatifs->links() }} -->
</div>

@endsection