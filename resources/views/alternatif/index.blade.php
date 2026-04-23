@extends('layout.admin')

@section('content')
<h3>Data Alternatif</h3>

<a href="{{ route('alternatif.create') }}" class="btn btn-primary mb-3">Tambah</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
        <tr>
            <td>{{ $d->nama }}</td>
            <td>
                <a href="{{ route('alternatif.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('alternatif.destroy', $d->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection