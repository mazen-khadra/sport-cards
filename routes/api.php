<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth as AuthController;
use App\Http\Controllers\User as UserController;
use App\Http\Controllers\Img as ImgController;
use App\Http\Controllers\UserPlayers as UserPlayersController;
use App\Http\Controllers\Invitation as InvitationController;
use App\Http\Controllers\Matches as MatchesController;

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
    Route::get('/{user}/info', [UserController::class, "getDetails"]);
    Route::put('/players', function(Request $req) {
        return (new UserPlayersController())->resetUserPlayers (
            $req, null, true
        );
    });
    Route::get('/players', [UserPlayersController::class, "getUserPlayers"]);
    Route::get('/list', [UserController::class, "index"]);
    Route::delete('/player', [UserPlayersController::class, "deletePlayer"]);
});

Route::prefix('resource')->group(function() {
    Route::post('/img', [ImgController::class, 'uploadImg']);
});


Route::prefix('invitation')->middleware('auth:sanctum')->group(function() {
    Route::get('/', [InvitationController::class, 'index']);
    Route::post('/', [InvitationController::class, 'add']);
    Route::put('/{invitation}/decide', [InvitationController::class, 'decide']);
});

Route::prefix('matches')->middleware('auth:sanctum')->group(function() {
    Route::get('/', [MatchesController::class, 'index']);
    Route::post('/', [MatchesController::class, 'add']);
});
