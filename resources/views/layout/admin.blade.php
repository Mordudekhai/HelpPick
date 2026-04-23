<!DOCTYPE html>
<html>

<head>
    <title>Admin - HelpPick</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="d-flex">

        <!-- SIDEBAR -->
        <div class="bg-dark text-white d-flex flex-column p-3" style="width:220px; min-height:100vh;">

            <div>
                <h5>HelpPick Admin</h5>
                <hr>

                <a href="{{ route('admin.dashboard') }}" class="text-white d-block mb-2">Dashboard</a>

                <a href="{{ route('alternatif.index') }}" class="text-white d-block mb-2">
                    Manajemen Alternatif
                </a>

                <a href="{{ route('kriteria.index') }}" class="text-white d-block mb-2">
                    Manajemen Kriteria
                </a>

                <a href="{{ route('penilaian.index') }}" class="text-white d-block mb-2">
                    Manajemen Penilaian
                </a>
            </div>

            <!-- BAGIAN BAWAH -->
            <div class="mt-auto">
                <hr>

                <div class="mb-2">
                    <small>Login sebagai:</small><br>
                    <strong>{{ session('admin_name') }}</strong>
                </div>

                <a href="{{ route('admin.logout') }}" class="btn btn-danger btn-sm w-100">
                    Keluar
                </a>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="p-4 w-100">
            @yield('content')
        </div>

    </div>

</body>

</html>