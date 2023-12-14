<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\IndexController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(IndexController::class)->group(function(){

Route::get('/','Index');
Route::post('/login','Login');
Route::get('/logout','Logout');

});

Route::group(['middleware' => ['auth']], function () {

    Route::controller(DashboardController::class)->group(function(){

        Route::get('/dashboard','Index');
    });

    Route::controller(DepositController::class)->group(function(){

        Route::get('/deposits','Index');
        Route::get('/deposit-edit/{deposit}','EditDeposit');
        Route::post('/deposit-edit/{deposit}','UpdateDeposit');
    });

    Route::controller(GameController::class)->group(function(){
        Route::get('/games','Index');
        Route::get('/game-detail/{game}','GameDetail');
        Route::post('/game-detail/{game}','GameDetailUpdate');
    });

});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');

    return "cache is clear";
});
