@extends('layout.admin')

@section('content')
<h3>Edit Alternatif</h3>

<form action="{{ route('alternatif.update', $data->id) }}" method="POST">
    @csrf @method('PUT')

    <div class="mb-3">
        <label>Nama Laptop</label>
        <input type="text" name="nama" value="{{ $data->nama }}" class="form-control" required>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection