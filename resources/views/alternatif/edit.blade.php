@extends('layout.admin')

@section('content')

<div class="table-page">

    <h4 class="mb-3">Edit Alternatif</h4>

    <a href="{{ route('alternatif.index') }}" class="btn btn-secondary mb-3">
        ← Kembali
    </a>

    <div class="table-area">
        <div class="table-scroll">

            <div style="max-width:100%; margin:auto; padding:20px;">

                <form action="{{ route('alternatif.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <strong class="form-label">Nama Laptop</strong>
                        <input type="text" name="nama" value="{{ $data->nama }}" class="form-control mt-2" required>
                    </div>

                    <button class="btn btn-primary w-100 mt-3">
                        Update
                    </button>

                </form>

            </div>
        </div>

    </div>

    @endsection