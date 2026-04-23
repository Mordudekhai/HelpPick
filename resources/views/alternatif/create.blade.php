@extends('layout.admin')

@section('content')
<h3>Tambah Alternatif</h3>

<form action="{{ route('alternatif.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Nama Laptop</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <button class="btn btn-success">Simpan</button>
</form>
@endsection