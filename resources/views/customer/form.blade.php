@extends('layout.app')

@section('content')

<style>
.btn-modern-primary {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 12px;
    font-weight: 500;
    transition: 0.25s;
    margin-top: 15px;
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.35);
    color: #fff;
}

.select-modern {
    border-radius: 10px;
    padding: 10px;
}

/* 🔥 TAMBAHAN KECIL (TIDAK MERUSAK STYLE) */
.radio-modern {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.radio-modern:hover {
    background: #f1f5f9;
}
</style>

<div class="card-modern">

    <a href="{{ route('home') }}" class="btn btn-secondary mb-3">
        ← Kembali ke Beranda
    </a>

    {{-- 🔥 UBAH JUDUL (MENYESUAIKAN SAW) --}}
    <h4 class="mb-3">Tentukan Tingkat Kepentingan</h4>

    <div class="alert alert-info">
        <strong>Petunjuk:</strong>
        Tentukan seberapa penting setiap kriteria bagi Anda.
    </div>

    <form action="{{ route('customer.hitung') }}" method="POST">
        @csrf

        @foreach($kriterias as $k)
        <div class="mb-4 p-3 border rounded-3 bg-light">

            <div class="fw-semibold mb-2">
                {{ $k->nama }}
            </div>

            {{-- 🔥 GANTI DROPDOWN → RADIO (SAW) --}}
            <div class="d-flex flex-wrap gap-2">

                <label class="radio-modern">
                    <input type="radio" name="bobot[{{ $k->id }}]" value="5" required>
                    <span>Sangat Penting</span>
                </label>

                <label class="radio-modern">
                    <input type="radio" name="bobot[{{ $k->id }}]" value="4">
                    <span>Penting</span>
                </label>

                <label class="radio-modern">
                    <input type="radio" name="bobot[{{ $k->id }}]" value="3">
                    <span>Cukup</span>
                </label>

                <label class="radio-modern">
                    <input type="radio" name="bobot[{{ $k->id }}]" value="2">
                    <span>Kurang</span>
                </label>

                <label class="radio-modern">
                    <input type="radio" name="bobot[{{ $k->id }}]" value="1">
                    <span>Tidak Penting</span>
                </label>

            </div>

        </div>
        @endforeach

        {{-- 🔥 TIDAK DIUBAH --}}
        <button class="btn-modern-primary w-100 mt-3 mb-4">
            🔍 Cari Rekomendasi
        </button>

    </form>

</div>

@endsection