@extends('layout.admin')

@section('content')

<div class="table-page">

    <h4 class="mb-3">Data Kriteria</h4>

    <a href="{{ route('kriteria.create') }}" class="btn btn-primary mb-3">
        Tambah
    </a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-area">

        <!-- 🔥 SCROLL AREA -->
        <div class="table-scroll">
            <table class="table-modern">

                <thead>
                    <tr>
                        <th style="width:80px;">Kode</th>
                        <th style="min-width:220px;">Nama</th>
                        <th style="width:120px;">Tipe</th>
                        <th style="width:160px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $d)
                    <tr>

                        <td class="kode-cell">
                            {{ $d->kode }}
                        </td>

                        <td class="nama-cell">
                            {{ $d->nama }}
                        </td>

                        <td class="text-center">
                            @if($d->isBenefit())
                            <span class="badge bg-success">Benefit</span>
                            @elseif($d->isCost())
                            <span class="badge bg-danger">Cost</span>
                            @else
                            <span class="badge bg-secondary">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('kriteria.edit', $d->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <a href="{{ route('kriteria.parameter', $d->id) }}" class="btn btn-info btn-sm">
                                Parameter
                            </a>

                            <form action="{{ route('kriteria.destroy', $d->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- 🔥 PAGINATION FIX DI BAWAH -->
        <div class="table-footer">
            <!--{{ $data->links() }} -->
        </div>

    </div>

</div>

@endsection