<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data pengguna yang terautentikasi
        $user = Auth::user();

        // Menampilkan dashboard berdasarkan role
        if ($user->role === 'admin') {
            // Logika untuk admin, misalnya mengambil data statistik
            // Contoh: $statistics = SomeModel::getStatistics();

            return view('admin.dashboard', [
                'user' => $user,
                // 'statistics' => $statistics, // Tambahkan data yang dibutuhkan
            ]);
        } elseif ($user->role === 'pelajar') {
            // Logika untuk pelajar
            return view('admin.dashboard', [ // Assuming you want to use the same view
                'user' => $user,
            ]);
        } elseif ($user->role === 'guru') {
            // Logika untuk guru
            return view('admin.dashboard', [ // Assuming you want to use the same view
                'user' => $user,
            ]);
        }

        // Jika role tidak dikenali
        return redirect('/login')->withErrors(['message' => 'Unauthorized access.']);
    }
}
