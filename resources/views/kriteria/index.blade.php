@extends('layout.admin')

@section('content')
<h3>Data Kriteria</h3>

<a href="{{ route('kriteria.create') }}" class="btn btn-primary mb-3">Tambah</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Tipe</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $d)
        <tr>
            <td>{{ $d->nama }}</td>

            <td>
                @if($d->isBenefit())
                <span class="badge bg-success">Benefit</span>
                @elseif($d->isCost())
                <span class="badge bg-danger">Cost</span>
                @else
                <span class="badge bg-secondary">-</span>
                @endif
            </td>

            <td>
                <a href="{{ route('kriteria.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('kriteria.destroy', $d->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">Belum ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection