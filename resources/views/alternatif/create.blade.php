@extends('layout.admin')

@section('content')

<div class="table-page">

    <h4 class="mb-3">Tambah Alternatif</h4>

    <a href="{{ route('alternatif.index') }}" class="btn btn-secondary mb-3">
        ← Kembali
    </a>

    <div class="table-area">
        <div class="table-scroll">

            <div style="max-width:100%; margin:auto; padding:20px;">

                <form action="{{ route('alternatif.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <strong>Nama Laptop</strong>
                        <input type="text" name="nama" class="form-control mt-2" required>
                    </div>

                    <button class="btn btn-success w-100 mt-3">
                        Simpan
                    </button>

                </form>

            </div>

        </div>
    </div>

</div>

@endsection