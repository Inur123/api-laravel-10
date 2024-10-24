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
    Route::get('/logout', [AuthController::class, 'logout']);

});

// Rute yang memerlukan autentikasi (user sudah login)
Route::middleware(['web', 'auth:web'])->group(function () {
    Route::get('/registration-statistics', [AuthController::class, 'getRegistrationStatistics']);
    // User route to get authenticated user details (session-based)
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::put('/user', [AuthController::class, 'update']);

    // Menstrual Cycle routes
    Route::put('/menstrual-cycle', [MenstrualCycleController::class, 'update']);
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
