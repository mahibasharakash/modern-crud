<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('users', AppController::class);
Route::post('/users/selected', [AppController::class, 'destroyBySelected']);
Route::post('/users/{id}/archive', [AppController::class, 'archive']);
Route::post('/users/{id}/unArchive', [AppController::class, 'unArchive']);
Route::post('/users/truncate', [AppController::class, 'clear']);
