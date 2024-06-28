<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\LoginLogoutController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//Reset paswword
Route::get('/reset-password', [PasswordController::class, 'resetPasswordLoad'])->name('users.reset');
Route::post('/reset-password/{userId}', [PasswordController::class, 'resetPassword'])->name('users.resetpassword');


//Verfiy Email

Route::get('verify-email', [LoginLogoutController::class, 'emailVerification']);


//levels
Route::get('/create-level', [LevelController::class, 'create'])->name('create.level');
Route::post('/insert-new-level', [LevelController::class, 'store'])->name('store.level');


//questions
Route::get('/create-question', [QuestionController::class, 'create'])->name('create.question');
Route::post('/insert-new-question', [QuestionController::class, 'store'])->name('store.question');