<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;

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
Route::post('/users/selected/{id}/archive', [AppController::class, 'archiveBySelected']);
Route::post('/users/{id}/unArchive', [AppController::class, 'unArchive']);
Route::post('/users/selected/{id}/unArchive', [AppController::class, 'unArchiveBySelected']);
Route::post('/users/truncate', [AppController::class, 'clear']);

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('AUTH.LOGIN.API');
    Route::post('registration', [AuthController::class, 'registration'])->name('AUTH.REGISTRATION.API');
    Route::post('forgot', [AuthController::class, 'forgot'])->name('AUTH.FORGOT.API');
    Route::post('verification', [AuthController::class, 'verification'])->name('AUTH.VERIFICATION.API');
    Route::post('reset', [AuthController::class, 'reset'])->name('AUTH.RESET.API');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('details', [AuthController::class, 'details'])->name('PROFILE.DETAILS.API');
        Route::put('change-Details', [AuthController::class, 'changeDetails'])->name('PROFILE.CHANGE.DETAILS.API');
        Route::put('change-Password', [AuthController::class, 'changePassword'])->name('PROFILE.CHANGE.PASSWORD.API');
        Route::post('logout', [AuthController::class, 'logout'])->name('PROFILE.LOGOUT.API');
    });
});
