@extends('layout.admin')

@section('content')
<h3>Edit Kriteria</h3>

<form action="{{ route('kriteria.update', $data->id) }}" method="POST">
    @csrf @method('PUT')

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" value="{{ $data->nama }}" class="form-control" required>
    </div>

    {{-- Bobot DIHAPUS dari form, tapi tetap tersimpan di DB --}}

    <div class="mb-3">
        <label>Tipe</label>
        <select name="tipe" class="form-control" required>
            <option value="benefit" {{ $data->tipe == 'benefit' ? 'selected' : '' }}>Benefit</option>
            <option value="cost" {{ $data->tipe == 'cost' ? 'selected' : '' }}>Cost</option>
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection