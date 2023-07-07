<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth as AuthController;
use App\Http\Controllers\User as UserController;
use App\Http\Controllers\Img as ImgController;
use App\Http\Controllers\UserPlayers as UserPlayersController;

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

Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, "signUp"]);
    Route::post('/login', [AuthController::class, "logIn"]);
    Route::get('/user', [AuthController::class, "getLoggedInUser"])->middleware("auth:sanctum");
});


Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::put('/info', [UserController::class, "updateUserInfo"]);
    Route::get('/info', [UserController::class, "updateUserInfo"]);
    Route::put('/players', [UserPlayersController::class, "resetUserPlayers"]);
    Route::get('/players', [UserPlayersController::class, "getUserPlayers"]);
});

Route::prefix('resource')->group(function() {
    Route::post('/img', [ImgController::class, 'uploadImg']);
});


