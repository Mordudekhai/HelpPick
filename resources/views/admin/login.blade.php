<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel - HelpPick</title>

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

    .login-card {
        background: #fff;
        padding: 40px 35px;
        border-radius: 20px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .title {
        text-align: center;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #1e293b;
    }

    .subtitle {
        text-align: center;
        font-size: 14px;
        color: #64748b;
        margin-bottom: 25px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        padding: 10px;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .btn-modern {
        border-radius: 10px;
        padding: 10px;
        font-weight: 500;
        transition: 0.2s;
    }

    .btn-modern:hover {
        transform: translateY(-1px);
    }

    .btn-dark {
        background: #111827;
        border: none;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 15px;
        font-size: 14px;
        color: #64748b;
        text-decoration: none;
    }

    .back-link:hover {
        color: #111827;
    }

    .form-label {
        font-weight: 500;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .input-icon input {
        padding-left: 32px;
    }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="title">
            <i class="fa-solid fa-gear"></i> Panel Admin
        </div>

        <div class="subtitle">
            Masuk untuk mengelola sistem
        </div>

        @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="mb-3 input-icon">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="mb-3 input-icon">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button class="btn btn-dark btn-modern w-100">
                <i class="fa-solid fa-right-to-bracket"></i>
                Masuk
            </button>
        </form>

        <a href="/" class="back-link">
            ← Kembali ke Beranda
        </a>

    </div>

</body>

</html>