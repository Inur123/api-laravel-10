<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Model User
use App\Models\GirlyPedia; // Model GirlyPedia
use App\Models\Podcast; // Model Podcast

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data pengguna yang terautentikasi
        $user = Auth::user();

        // Menghitung total pengguna
        $totalUsers = User::count();

        // Menghitung total role pelajar dan guru
        $totalPelajar = User::where('role', 'pelajar')->count();
        $totalGuru = User::where('role', 'guru')->count();

        // Menghitung total data GirlyPedia dan Podcast
        $totalGirlyPedia = GirlyPedia::count();
        $totalPodcast = Podcast::count();

        // Menampilkan dashboard berdasarkan role
        $viewData = [
            'user' => $user,
            'totalUsers' => $totalUsers,
            'totalPelajar' => $totalPelajar,
            'totalGuru' => $totalGuru,
            'totalGirlyPedia' => $totalGirlyPedia,
            'totalPodcast' => $totalPodcast,
        ];

        // Menggunakan view yang sama untuk semua role
        return view('admin.dashboard', $viewData);
    }
}
