@extends('layout.admin')

@section('content')
<h3>Tambah Kriteria</h3>

<a href="{{ route('kriteria.index') }}" class="btn btn-secondary mb-3">
    ← Kembali
</a>

<form action="{{ route('kriteria.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Tipe</label>
        <select name="tipe" class="form-control" required>
            <option value="">-- Pilih --</option>
            <option value="benefit">Benefit</option>
            <option value="cost">Cost</option>
        </select>
    </div>

    <button class="btn btn-success">Simpan</button>
</form>
@endsection