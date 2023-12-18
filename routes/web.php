<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\KYCController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WithdrawalController;
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
        Route::get('/game-delete/{game}','GameDelete');
    });

    Route::controller(WithdrawalController::class)->group(function(){
       Route::get('/withdrawals','Index');
       Route::get('/withdrawal-edit/{withdrawal}','WithdrawalEdit');
       Route::post('/withdrawal-edit/{withdrawal}','WithdrawalUpdate');
    });

    Route::controller(CategoryController::class)->group(function(){

        Route::get('/categories','Index');
        Route::get('/category-create','CategoryCreate');
        Route::post('/category-create','CategoryStore');
        Route::get('/category-edit/{category}','CategoryEdit');

    });

    Route::controller(KYCController::class)->group(function(){

        Route::get('/kycs','Index');
        Route::get('/kyc-edit/{userDetail}','KYCEdit');
        Route::post('/kyc-edit/{userDetail}','KYCUpdate');
    });

    Route::controller(SettingController::class)->group(function(){

        Route::get('/settings','Index');
        Route::post('/settings','Update');
    });

    Route::controller(UserController::class)->group(function(){

        Route::get('/users','Index');
        Route::get('/user-edit/{user}','UserEdit');
        Route::post('/user-edit/{user}','UserUpdate');
        Route::get('/user-view/{user}','UserView');
    });
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');

    return "cache is clear";
});
