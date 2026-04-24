<!DOCTYPE html>
<html>

<head>
    <title>Admin - HelpPick</title>

    {{-- GOOGLE FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- ICON --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- GLOBAL CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
    /* =========================
   GLOBAL FIX (WAJIB)
========================= */
    html,
    body {
        height: 100%;
        margin: 0;
        overflow: hidden;
        /* 🔥 hilangkan scroll halaman */
        font-family: "Inter", sans-serif;
        background: #f5f7fb;
    }

    /* =========================
   APP LAYOUT
========================= */
    .app-container {
        height: 100vh;
        display: flex;
    }

    /* =========================
   SIDEBAR
========================= */
    .sidebar {
        width: 240px;
        background: linear-gradient(180deg, #0f172a, #1e293b);
        color: #fff;
        display: flex;
        flex-direction: column;
        padding: 20px;
    }

    .sidebar-title {
        font-weight: 600;
        font-size: 18px;
        letter-spacing: 0.5px;
    }

    .sidebar hr {
        border-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar a {
        text-decoration: none;
        color: #cbd5f5;
        padding: 10px 12px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 6px;
        transition: 0.2s;
    }

    .sidebar a:hover {
        background: #334155;
        color: #fff;
        transform: translateX(3px);
    }

    .sidebar a.active {
        background: #2563eb;
        color: #fff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* =========================
   MAIN CONTENT (FULL HEIGHT)
========================= */
    .main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        height: 100vh;
        padding: 25px;
    }

    /* =========================
   TOPBAR
========================= */
    .topbar {
        background: #fff;
        border-radius: 14px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .topbar-title {
        font-weight: 600;
        font-size: 18px;
    }

    /* =========================
   CONTENT BODY (NO SCROLL)
========================= */
    .content-body {
        flex: 1;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    /* =========================
   CARD (FULL HEIGHT)
========================= */
    .card-modern {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);

        /* 🔥 ini penting */
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* =========================
   BUTTON
========================= */
    .btn {
        border-radius: 8px !important;
    }

    /* =========================
   USER BOX
========================= */
    .sidebar-footer {
        margin-top: auto;
    }

    .user-box {
        background: rgba(255, 255, 255, 0.05);
        padding: 10px;
        border-radius: 10px;
    }
    </style>
</head>

<body>

    <div class="app-container">

        <!-- SIDEBAR -->
        <div class="sidebar">

            <div>
                <div class="sidebar-title mb-3">
                    <i class="fa-solid fa-laptop"></i> HelpPick
                </div>

                <hr>

                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>

                <a href="{{ route('alternatif.index') }}"
                    class="{{ request()->routeIs('alternatif.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list"></i>
                    Alternatif
                </a>

                <a href="{{ route('kriteria.index') }}" class="{{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-filter"></i>
                    Kriteria
                </a>

                <a href="{{ route('mapping.index') }}" class="{{ request()->routeIs('mapping.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-sliders"></i>
                    Penilaian
                </a>

            </div>

            <!-- FOOTER -->
            <div class="sidebar-footer">

                <hr>

                <div class="user-box mb-3">
                    <small class="text-light">Login sebagai</small><br>
                    <strong>{{ session('admin_name') }}</strong>
                </div>

                <a href="{{ route('admin.logout') }}" class="btn btn-danger w-100">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </a>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="main-content">

            <!-- TOPBAR -->
            <div class="topbar">
                <div class="topbar-title">
                    @yield('title', 'Dashboard')
                </div>

                <div>
                    <i class="fa-solid fa-user-circle me-2"></i>
                    {{ session('admin_name') }}
                </div>
            </div>

            <!-- 🔥 CONTENT BODY (WAJIB ADA) -->
            <div class="content-body">

                <!-- 🔥 CARD FULL HEIGHT -->
                <div class="card-modern">
                    @yield('content')
                </div>

            </div>

        </div>

    </div>

</body>

</html>