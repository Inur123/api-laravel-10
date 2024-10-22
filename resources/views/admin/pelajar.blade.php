<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelajar</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Ganti dengan path CSS Anda -->
</head>
<body>
    <h1>Welcome, {{ $user->name }} (Pelajar)</h1>
    <p>This is your student dashboard.</p>
    <!-- Tambahkan data dan informasi yang relevan untuk pelajar -->
</body>
</html>
