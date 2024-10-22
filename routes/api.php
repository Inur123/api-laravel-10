<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\PodcastController;
use App\Http\Controllers\API\GirlyPediaController;
use App\Http\Controllers\API\MenstrualCycleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rute tanpa autentikasi (Login, Register, Logout)
Route::middleware('web')->group(function () {

    // Authentication routes (session-based for login/logout)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Rute yang memerlukan autentikasi (user sudah login)
Route::middleware(['web', 'auth:web'])->group(function () {

    // User route to get authenticated user details (session-based)
    Route::get('/user', [AuthController::class, 'getUser']);

    // Menstrual Cycle routes
    Route::put('menstrual-cycles/{id}', [MenstrualCycleController::class, 'update']);
    Route::get('/menstrual-cycles', [MenstrualCycleController::class, 'index']);
    Route::post('/menstrual-cycle', [MenstrualCycleController::class, 'store']);
    Route::post('/check-cycle', [MenstrualCycleController::class, 'checkCycle']);

    // Welcome route
    Route::get('/welcome', [StatusController::class, 'welcome']);

    // Girly Pedia routes using resource controller
    Route::apiResource('/girly-pedia', GirlyPediaController::class);

    // Podcast routes using resource controller
    Route::apiResource('/podcasts', PodcastController::class);
});
