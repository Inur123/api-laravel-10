<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\DailyTaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GirlyPediaController;
use App\Http\Controllers\NotificationController;

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

Route::resource('challenges', ChallengeController::class);

Route::resource('daily_tasks', DailyTaskController::class);
Route::get('/notifications', [NotificationController::class, 'showNotifications'])->name('notifications.index');
