@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h1>Welcome, {{ Auth::user()->name }} (Admin)</h1> <!-- Menggunakan Auth untuk mendapatkan nama pengguna -->
    <p>This is your admin dashboard.</p>
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="logout-button">Logout</button>
    </form>
    <!-- Tambahkan data dan statistik yang diperlukan -->
@endsection
