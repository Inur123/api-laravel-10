<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StatusController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Default homepage
Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [StatusController::class, 'welcome']);
