<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthWebController;

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
