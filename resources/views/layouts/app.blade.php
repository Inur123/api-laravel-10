<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Ganti dengan path CSS Anda -->
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f8f9fa;
            position: fixed;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Menambahkan scroll jika konten terlalu banyak */
        }
        .content {
            margin-left: 260px; /* Lebar sidebar */
            padding: 20px;
            transition: margin-left 0.3s; /* Animasi saat sidebar berubah */
        }
        h1 {
            margin-bottom: 20px;
        }
        .logout-button {
            background-color: #f44336; /* Warna merah untuk tombol logout */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-button:hover {
            background-color: #d32f2f; /* Warna lebih gelap saat hover */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Menu</h2>
        <ul>
            <li><a href="{{ route('dashboard') }}" class="text-blue-600">Dashboard</a></li> <!-- Link ke Dashboard -->
            <li><a href="{{ route('girlyPedia.index') }}" class="text-blue-600">Manage GirlyPedia</a></li>
            <li><a href="{{ route('podcasts.index') }}" class="text-blue-600">Manage Podcasts</a></li> <!-- Link ke Podcast Management -->
            <!-- Tambahkan menu lain jika diperlukan -->
        </ul>
    </div>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>
