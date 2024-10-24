<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\PodcastController;
use App\Http\Controllers\API\ChallengeController;
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
    // Authentication statistics and user profile
    Route::get('/registration-statistics', [AuthController::class, 'getRegistrationStatistics']);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::put('/user', [AuthController::class, 'update']);

    // Menstrual Cycle routes using apiResource
    Route::apiResource('/menstrual-cycles', MenstrualCycleController::class)->only(['index', 'store', 'update']);
    Route::post('/check-cycle', [MenstrualCycleController::class, 'checkCycle']);

    // Welcome route
    Route::get('/welcome', [StatusController::class, 'welcome']);

    // Girly Pedia routes using apiResource
    Route::apiResource('/girly-pedia', GirlyPediaController::class);

    // Podcast routes using apiResource
    Route::apiResource('/podcasts', PodcastController::class);

    // Challenge routes
Route::apiResource('/challenges', ChallengeController::class)->only(['index', 'store']);

// Route to add daily tasks to a challenge owned by the current user
Route::post('/challenges/dailies', [ChallengeController::class, 'storeDaily']);

// Route to update challenge progress
Route::put('/challenges/{challenge}/progress', [ChallengeController::class, 'updateProgress']);

// Route to update daily task
Route::put('/dailies/{daily}', [ChallengeController::class, 'updateDaily']);

// Mark daily task as completed
Route::patch('dailies/{dailyId}/complete', [ChallengeController::class, 'completeDailyTask']);

});
