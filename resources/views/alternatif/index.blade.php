@extends('layout.admin')

@section('content')

<div class="table-page">

    <h4 class="mb-3">Data Alternatif</h4>

    <a href="{{ route('alternatif.create') }}" class="btn btn-primary mb-3">
        + Tambah Alternatif
    </a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-area">

        <div class="table-scroll">
            <table class="table-modern">

                <thead>
                    <tr>
                        <th style="width:80px;">Kode</th>
                        <th style="min-width:220px;">Nama</th>
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

                            <a href="{{ route('alternatif.edit', $d->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('alternatif.destroy', $d->id) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Belum ada data alternatif
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="table-footer">
            <!-- {{ $data->links() }} -->
        </div>

    </div>

</div>

@endsection