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

// Apply the 'web' middleware to all routes to use session-based auth
Route::middleware('web')->group(function () {

    // User route to get authenticated user details (session-based)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Authentication routes (session-based for login/logout)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);

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
