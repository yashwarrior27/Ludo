<?php

use App\Http\Controllers\Api\AssetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReportController;

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
Route::get('/settings','Settings');

});

Route::group(['middleware' => ['auth:api','checkstatus']],function(){

    Route::controller(AuthController::class)->group(function(){

        Route::post('/change-username','ChangeUserName');
        Route::get('/user-profile','UserProfile');
        Route::get('/kyc-data','KYCData');
        Route::post('/set-kyc-data','KYCUpdate');
        Route::get('/referral-data','GetReferralData');
        Route::get('/wallet-balance','WalletBalance');
        Route::get('/logout','Logout');
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
        Route::post('/set-game-status','StatusUpdate');
        Route::get('/running-battle','RunningBattle');
    });


    Route::controller(PaymentController::class)->group(function(){

       Route::get('/deposit-data','DepositData');
       Route::post('/make-deposit','MakeDeposit');
       Route::post('/withdrawal-request','Withdrawal');
       Route::get('/withdrawalable-amount','WithdrawalableAmount');

    });

    Route::controller(ReportController::class)->group(function(){

        Route::get('/referral-report','ReferralReport');
        Route::get('/game-report','GameReport');
        Route::get('/deposit-report','DepositReport');
        Route::get('/transaction-report','TransactionReport');
        Route::get('/penalty-report','PenaltyReport');
        Route::get('/withdrawal-report','WithdrawalReport');
    });

});
