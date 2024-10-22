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

// User route to get authenticated user details
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Menstrual Cycle routes
Route::middleware('auth:sanctum')->put('menstrual-cycles/{id}', [MenstrualCycleController::class, 'update']);
Route::middleware('auth:sanctum')->get('/menstrual-cycles', [MenstrualCycleController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/menstrual-cycle', [MenstrualCycleController::class, 'store']);
Route::middleware('auth:sanctum')->post('/check-cycle', [MenstrualCycleController::class, 'checkCycle']);
Route::get('/welcome', [StatusController::class, 'welcome']);

// Girly Pedia routes


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/girly-pedia', [GirlyPediaController::class, 'index']);
    Route::post('/girly-pedia', [GirlyPediaController::class, 'store']);
    Route::get('/girly-pedia/{id}', [GirlyPediaController::class, 'show']);
    Route::put('/girly-pedia/{id}', [GirlyPediaController::class, 'update']);
    Route::delete('/girly-pedia/{id}', [GirlyPediaController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Menampilkan semua podcast
    Route::get('/podcasts', [PodcastController::class, 'index']);

    // Menampilkan satu podcast berdasarkan ID
    Route::get('/podcasts/{id}', [PodcastController::class, 'show']);

    // Menambahkan podcast baru
    Route::post('/podcasts', [PodcastController::class, 'store']);

    // Memperbarui podcast berdasarkan ID
    Route::put('/podcasts/{id}', [PodcastController::class, 'update']);

    // Menghapus podcast berdasarkan ID
    Route::delete('/podcasts/{id}', [PodcastController::class, 'destroy']);
});
