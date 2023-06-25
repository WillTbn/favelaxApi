<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ModelatorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:api','can:modelador'])->group(function(){
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
});
Route::middleware(['auth:api', 'can:nvlOne'])->group(function(){
    Route::delete('/user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');

});
Route::middleware(['auth:api', 'can:nvltwo'])->group(function(){
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
});

Route::middleware(['auth:api','can:admin'])->group(function(){
    Route::group(['prefix' =>'user'], function($router){
        Route::get('/trashed', [UserController::class, 'trashed'])->name('user.trashe');
        Route::post('/', [UserController::class, 'create'])->name('user.create');
        Route::put('/restore/{user}', [UserController::class, 'restore'])->name('user.restore');
        Route::delete('/user/forcedelete/{user}', [UserController::class, 'deleteForce'])->name('user.delete');
    });

    Route::group(['prefix'=>'admin'],function($router){
        Route::post('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::get('/details', [AuthController::class, 'getUserDetail'])->name('admin.details');
        Route::get('/readAll', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/{user}', [AdminController::class, 'show'])->name('admin.show');
        Route::put('/{user}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');

    });
    Route::group(['prefix'=>'modelador'],function($router){
        Route::get('/', [ModelatorController::class, 'index'])->name('modelador.index');
        Route::post('/', [ModelatorController::class, 'create'])->name('modelador.create');
        Route::get('/{user}', [ModelatorController::class, 'show'])->name('modelador.show');
        Route::put('/{user}', [ModelatorController::class, 'update'])->name('modelador.update');
        Route::delete('/{user}', [ModelatorController::class, 'destroy'])->name('modelador.destroy');
    });
    Route::group(['prefix'=>'finance'],function($router){
        Route::get('/', [FinanceController::class, 'index'])->name('finance.index');
        Route::post('/', [FinanceController::class, 'create'])->name('finance.create');
        Route::get('/{user}', [FinanceController::class, 'show'])->name('finance.show');
        Route::put('/{user}', [FinanceController::class, 'update'])->name('finance.update');
        Route::delete('/{user}', [FinanceController::class, 'destroy'])->name('finance.destroy');
    });
});
