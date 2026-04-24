@extends('layout.admin')

@section('content')

<div class="table-page d-flex flex-column h-100">

    <h4 class="mb-3">Mapping Parameter ke Alternatif</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('mapping.store') }}" method="POST" class="d-flex flex-column h-100">
        @csrf

        <div class="table-area d-flex flex-column flex-grow-1">

            <!-- 🔥 SCROLL AREA UTAMA (VERTICAL + HORIZONTAL) -->
            <div class="table-scroll flex-grow-1" style="
                overflow: auto;
                max-height: calc(100vh - 260px);
            ">

                <!-- 🔥 WRAPPER BIAR HORIZONTAL SCROLL -->
                <div style="min-width:1200px;">

                    <table class="table-modern">

                        <thead>
                            <tr>
                                <th style="width:80px;">Kode</th>
                                <th style="min-width:220px;">Alternatif</th>

                                @foreach($kriterias as $k)
                                <th style="min-width:200px;">{{ $k->kode }}</th>
                                @endforeach
                            </tr>

                            <tr>
                                <th></th>
                                <th></th>

                                @foreach($kriterias as $k)
                                <th>{{ $k->nama }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($alternatifs as $alt)
                            <tr>

                                <td class="kode-cell">
                                    {{ $alt->kode }}
                                </td>

                                <td class="nama-cell">
                                    {{ $alt->nama }}
                                </td>

                                @foreach($kriterias as $k)

                                @php
                                $key = $alt->id . '-' . $k->id;
                                $selectedScore = $penilaians[$key]->nilai ?? null;
                                $param = $k->parameters->firstWhere('score', $selectedScore);
                                @endphp

                                <td>

                                    <select name="nilai[{{ $alt->id }}][{{ $k->id }}]" class="form-control mb-1">

                                        <option value="">-- Pilih --</option>

                                        @foreach($k->parameters as $p)
                                        <option value="{{ $p->score }}"
                                            {{ $selectedScore == $p->score ? 'selected' : '' }}>

                                            @if($p->min_value || $p->max_value)
                                            {{ $p->min_value ?? '0' }} - {{ $p->max_value ?? '∞' }}
                                            @else
                                            {{ $p->label }}
                                            @endif

                                        </option>
                                        @endforeach

                                    </select>

                                    @if($param)
                                    <small class="text-muted">
                                        {{ $param->label }}
                                    </small>
                                    @endif

                                </td>

                                @endforeach

                            </tr>

                            @empty
                            <tr>
                                <td colspan="{{ 2 + count($kriterias) }}" class="text-center">
                                    Belum ada data alternatif
                                </td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>

            <!-- 🔥 FOOTER FIXED (TIDAK IKUT SCROLL) -->
            <div class="table-footer mt-2 d-flex justify-content-start">

                <button class="btn btn-success">
                    Simpan Mapping
                </button>

            </div>

        </div>

    </form>

</div>

@endsection