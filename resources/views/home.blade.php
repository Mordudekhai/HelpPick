<!DOCTYPE html>
<html>

<head>
    <title>HelpPick</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container text-center mt-5">
        <h1 class="mb-4">HelpPick</h1>
        <p class="mb-5">Sistem Pendukung Keputusan Pemilihan Laptop</p>

        <a href="{{ route('customer.form') }}" class="btn btn-primary btn-lg m-2">
            Masuk sebagai Customer
        </a>

        <a href="{{ route('admin.login') }}" class="btn btn-dark btn-lg m-2">
            Masuk sebagai Admin
        </a>
    </div>

</body>

</html>