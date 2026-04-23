@extends('layout.app')

@section('content')
<h3>Pilih Prioritas Kriteria</h3>

<div class="alert alert-info">
    <strong>Petunjuk:</strong><br>
    Pilih tingkat kepentingan setiap kriteria sesuai kebutuhan Anda:
    <ul class="mb-0 mt-2">
        <li><b>Sangat Penting</b> → sangat berpengaruh dalam keputusan</li>
        <li><b>Penting</b> → cukup berpengaruh</li>
        <li><b>Cukup Penting</b> → pertimbangan tambahan</li>
        <li><b>Kurang Penting</b> → tidak terlalu berpengaruh</li>
        <li><b>Tidak Terlalu Penting</b> → hampir tidak dipertimbangkan</li>
    </ul>
</div>

<form action="{{ route('customer.hitung') }}" method="POST">
    @csrf

    @foreach($kriterias as $k)
    <div class="mb-4">
        <label class="mb-2"><strong>{{ $k->nama }}</strong></label>

        <div>
            <label class="me-3">
                <input type="radio" name="bobot[{{ $k->id }}]" value="5" required> Sangat Penting
            </label>

            <label class="me-3">
                <input type="radio" name="bobot[{{ $k->id }}]" value="4"> Penting
            </label>

            <label class="me-3">
                <input type="radio" name="bobot[{{ $k->id }}]" value="3"> Cukup Penting
            </label>

            <label class="me-3">
                <input type="radio" name="bobot[{{ $k->id }}]" value="2"> Kurang Penting
            </label>

            <label>
                <input type="radio" name="bobot[{{ $k->id }}]" value="1"> Tidak Terlalu Penting
            </label>
        </div>
    </div>
    @endforeach

    <button class="btn btn-primary">Lihat Rekomendasi</button>

</form>
@endsection