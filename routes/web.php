<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GirlyPediaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Default homepage
Route::get('/', function () {
    return view('welcome'); // Pastikan Anda memiliki view welcome.blade.php
})->name('welcome');

Route::get('/login', [AuthWebController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Route resource for GirlyPedia
Route::resource('girlyPedia', GirlyPediaController::class)->middleware('auth');

// Resource route for podcasts
Route::resource('podcasts', PodcastController::class)->middleware('auth');
