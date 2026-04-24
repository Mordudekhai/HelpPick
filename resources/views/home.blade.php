<!DOCTYPE html>
<html>

<head>
    <title>HelpPick</title>

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    body {
        font-family: "Inter", sans-serif;
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .home-card {
        background: #fff;
        padding: 50px 40px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        max-width: 500px;
        width: 100%;
    }

    .logo-title {
        font-size: 32px;
        font-weight: 600;
        color: #1e293b;
    }

    .subtitle {
        color: #64748b;
        margin-top: 10px;
        margin-bottom: 30px;
    }

    .btn-modern {
        border-radius: 10px;
        padding: 12px;
        font-weight: 500;
        transition: 0.2s;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: #2563eb;
        border: none;
    }

    .btn-dark {
        background: #111827;
        border: none;
    }

    .btn i {
        margin-right: 6px;
    }
    </style>
</head>

<body>

    <div class="home-card">

        <div class="logo-title">
            <i class="fa-solid fa-laptop-code"></i> HelpPick
        </div>

        <div class="subtitle">
            Sistem Pendukung Keputusan untuk membantu Anda menentukan pilihan terbaik
            berdasarkan kriteria dan preferensi yang diinginkan
        </div>

        <div class="d-grid gap-3">

            <a href="{{ route('customer.form') }}" class="btn btn-primary btn-modern">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari Rekomendasi
            </a>

            <a href="{{ route('admin.login') }}" class="btn btn-dark btn-modern">
                <i class="fa-solid fa-gear"></i>
                Panel Admin
            </a>

        </div>

    </div>

</body>

</html>