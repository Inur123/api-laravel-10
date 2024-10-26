<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\PodcastController;
use App\Http\Controllers\API\ChallengeController;
use App\Http\Controllers\API\GirlyPediaController;
use App\Http\Controllers\API\MenstrualCycleController;
use App\Models\Challenge;

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
    Route::put('/menstrual-cycle', [MenstrualCycleController::class, 'update']);
    Route::get('/menstrual-cycles', [MenstrualCycleController::class, 'index']);
    Route::post('/menstrual-cycle', [MenstrualCycleController::class, 'store']);
    Route::post('/check-cycle', [MenstrualCycleController::class, 'checkCycle']);

    // Welcome route
    Route::get('/welcome', [StatusController::class, 'welcome']);

    // Girly Pedia routes using apiResource
    Route::apiResource('/girly-pedia', GirlyPediaController::class);

    // Podcast routes using apiResource

    Route::apiResource('/podcasts', PodcastController::class);

    Route::apiResource('challenges', ChallengeController::class);
    // Challenge routes

    Route::post('challenges/{challengeId}/tasks', [ChallengeController::class, 'createDailyTask']);
    Route::post('tasks/{taskId}/complete', [ChallengeController::class, 'markTaskAsCompleted']);

    Route::get('challenges/{challengeId}/user-progress', [ChallengeController::class, 'getUserProgress']);
    Route::get('/challenges/{challengeId}/user-progress', [ChallengeController::class, 'getUserDailyProgress']);
});


