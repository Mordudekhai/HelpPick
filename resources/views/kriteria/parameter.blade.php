@extends('layout.admin')

@section('content')

<div class="table-page">

    <h4 class="mb-3">Parameter: {{ $kriteria->nama }}</h4>

    <a href="{{ route('kriteria.index') }}" class="btn btn-secondary mb-3">
        ← Kembali
    </a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-area">

        <div class="table-scroll">

            {{-- =========================
               FORM PARAMETER
            ========================= --}}
            <form action="{{ route('kriteria.parameter.store', $kriteria->id) }}" method="POST">
                @csrf

                <table class="table-modern mb-3">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Min</th>
                            <th>Max</th>
                            <th>Score</th>
                        </tr>
                    </thead>

                    <tbody>

                        {{-- MODE EMPTY --}}
                        @if($parameters->isEmpty())

                        @for($i = 0; $i < 5; $i++) <tr>
                            <td><input type="text" name="label[]" class="form-control" required></td>
                            <td><input type="number" name="min[]" class="form-control"></td>
                            <td><input type="number" name="max[]" class="form-control"></td>
                            <td><input type="number" name="score[]" class="form-control" required></td>
                            </tr>
                            @endfor

                            {{-- MODE UPDATE --}}
                            @else

                            @foreach($parameters as $p)
                            <tr>
                                <td>
                                    <input type="text" name="label[]" value="{{ $p->label }}" class="form-control">
                                </td>
                                <td>
                                    <input type="number" name="min[]" value="{{ $p->min_value }}" class="form-control">
                                </td>
                                <td>
                                    <input type="number" name="max[]" value="{{ $p->max_value }}" class="form-control">
                                </td>
                                <td>
                                    <input type="number" name="score[]" value="{{ $p->score }}" class="form-control">
                                </td>
                            </tr>
                            @endforeach

                            @endif

                    </tbody>
                </table>

                {{-- BUTTON --}}
                @if($parameters->isEmpty())
                <button class="btn btn-success">Simpan</button>
                @else
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">Batal</a>
                @endif

            </form>

            {{-- =========================
               DATA TABLE
            ========================= --}}
            <h5 class="mt-4">Data Parameter</h5>

            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Score</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($parameters as $p)
                    <tr>
                        <td>{{ $p->label }}</td>
                        <td>{{ $p->score }}</td>
                        <td>
                            <form action="{{ route('kriteria.parameter.delete', $p->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

</div>

@endsection