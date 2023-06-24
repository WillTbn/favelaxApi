<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ModelatorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Silber\Bouncer\Bouncer;

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

Route::group(['prefix' => 'auth'], function(){
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
//control-all -> Admin
//view-registers -> Modelador
//Deleted-registers -> Financeiro nvl 1
//Edited-registers -> Financeiro nvl 2

Route::middleware(['auth:api','mod'])->group(function(){
    Route::get('/users', [UserController::class, 'index'])->name('UserAll');
});
Route::middleware(['auth:api','nvlone'])->group(function(){
    Route::delete('/user/destroy/{user}', [UserController::class, 'destroy'])->name('UserDestroy');

});
Route::middleware(['auth:api','nvltwo'])->group(function(){
    Route::put('/user/{user}', [UserController::class, 'update'])->name('UserUpdate');
});

Route::middleware(['auth:api','admin'])->group(function(){
    Route::group(['prefix' =>'user'], function($router){
        Route::get('/trashed', [UserController::class, 'trashed'])->name('UserTrashed');
        Route::post('/', [UserController::class, 'create'])->name('UserCreate');
        Route::put('/restore/{user}', [UserController::class, 'restore'])->name('UserRestore');
        Route::delete('/user/forcedelete/{user}', [UserController::class, 'deleteForce'])->name('UserDelete');
    });

    Route::group(['prefix'=>'admin'],function($router){
        Route::post('/create', [AdminController::class, 'create'])->name('AdminCreate');
        Route::get('/details', [AuthController::class, 'getUserDetail'])->name('AdminDetails');
        Route::get('/readAll', [AdminController::class, 'index'])->name('AdminReadAll');
        Route::get('/{user}', [AdminController::class, 'show'])->name('AdminShow');
        Route::put('/{user}', [AdminController::class, 'update'])->name('AdminUpdate');

    });
    Route::group(['prefix'=>'modelador'],function($router){
        Route::post('/', [ModelatorController::class, 'create'])->name('ModeladorCreated');
        Route::get('/{user}', [ModelatorController::class, 'show'])->name('ModeladorShow');
        Route::put('/{user}', [AdminController::class, 'update'])->name('ModeladorUpdate');
    });
    Route::group(['prefix'=>'finance'],function($router){
        // Bouncer::Allow('')
        Route::get('/', [FinanceController::class, 'index'])->name('FinanceAll');
        Route::post('/', [FinanceController::class, 'create'])->name('FinanceCreated');
        Route::get('/{user}', [FinanceController::class, 'show'])->name('FinanceShow');


    });
});
