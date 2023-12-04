<?php

use App\Http\Controllers\Api\AssetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;

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

Route::controller(AuthController::class)->group(function(){

    Route::post('/register','Register');
    Route::post('/login','Login');
    Route::post('/otp-verify','OTPVerify');
});

Route::controller(AssetController::class)->group(function(){

Route::get('/categories','Categories');
});

Route::group(['middleware' => ['auth:api']],function(){

    Route::controller(AuthController::class)->group(function(){

        Route::post('/change-username','ChangeUserName');
        Route::get('/user-profile','UserProfile');
        Route::get('/kyc-data','KYCData');
        Route::post('/set-kyc-data','KYCUpdate');
    });

    Route::controller(GameController::class)->group(function(){

        Route::post('/set-game','SetGame');
        Route::get('/open-battle','OpenBattle');
        Route::post('/play-game','PlayGame');
        Route::get('/current-game','CurrentGame');
        Route::post('/reject-game','RejectGame');
        Route::post('/delete-game','DeleteGame');
        Route::post('/start-game','StartGame');
        Route::get('/room-code','RoomCode');
        Route::post('/set-room-code','SetRoomCode');
        Route::post('/accept-room-code','AcceptRoomCode');
    });

});
