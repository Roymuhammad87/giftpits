<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\ProfileControler;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginLogoutController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//User auth

Route::prefix('users')->group(function () {
    Route::post('/register-new-user', RegisterController::class); //register new user
    Route::post('/login', [LoginLogoutController::class, 'login']); //login
    
});
Route::delete('/logout', [LoginLogoutController::class, 'logout'])->middleware('auth:sanctum'); //logout
Route::delete('/delete-user-account/{id}', [UserController::class, 'destroy'])->middleware('auth:sanctum'); //delete account
Route::put('/update-user', [UserController::class, 'update'])->middleware('auth:sanctum'); //update


//verification and password resets

Route::post('/users/verify-your-email/{email}', [LoginLogoutController::class, 'verifyEmailAddress'])->middleware('auth:sanctum');
Route::post('/users/forget-password', [PasswordController::class, 'forgetPassword']);

//levels
Route::prefix('levels')->group(function () {
    Route::get('/get-all-levels', [LevelController::class, 'index']);
    Route::post('/insert-new-level', [LevelController::class, 'store']);
});

//questions
Route::prefix('questions')->controller(QuestionController::class)->group(function () {
    Route::get('/get-questions', 'index');
    Route::get('/get-all-questions', 'getAllQuestions');
    Route::post('/insert-new-question', 'store');
});

//scores
Route::prefix('scores')->controller(ScoreController::class)->group(function(){
    Route::put('/update-user-score', 'update');
    Route::get('/get-user-score/{id}', 'index');
    Route::post('/insert-score', 'store');
    Route::get('/get-all-scores', 'allScores');
});
    //completed levels
    Route::get('/is-level-completed', [LevelController::class, 'markLevelCompleted']);
    Route::get('/get-completed-levels', [LevelController::class, 'getCompletedLevels']);


    //user's profile
    Route::post('/user-profile', [ProfileControler::class, 'updateUserProfile']);
    Route::get('/get-user-profile', [ProfileControler::class, 'getUserProfile']);

    //reward
    Route::put('/claim-daily-reward', [RewardController::class, 'claimDailyReward']);
