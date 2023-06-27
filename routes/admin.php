<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ModelerController;
use App\Http\Controllers\UserController;

Route::post('admin/login', [AdminLoginController::class, 'adminLogin'])->name('admin.login');

Route::group( ['prefix'=> 'admin', 'middleware' =>['auth:admin-api', 'scopes:admin'] ], function(){
    Route::post('dashboard', [AdminLoginController::class, 'adminDashboard'])->name('admin.dashboard');

});
Route::middleware(['auth:admin-api', 'scopes:admin'])->group(function(){
    Route::group(['prefix'=>'admin'],function($router){
        Route::post('/create', [AdminController::class, 'create'])->name('admin.create');
        // Route::get('/details', [AuthController::class, 'getUserDetail'])->name('admin.details');
        Route::get('/readAll', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/trashed', [AdminController::class, 'trashed'])->name('admin.trashe');
        Route::get('/{user}', [AdminController::class, 'show'])->name('admin.show');
        Route::put('/{user}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::put('/restore/{user}', [AdminController::class, 'restore'])->name('admin.restore');
        Route::delete('forcedelete/{user}', [AdminController::class, 'deleteForce'])->name('admin.delete');

    });
    Route::group(['prefix'=>'modeler'],function($router){
        Route::get('/', [ModelerController::class, 'index'])->name('modeler.index');
        Route::post('/', [ModelerController::class, 'create'])->name('modeler.create');
        Route::get('/trashed', [ModelerController::class, 'trashed'])->name('modeler.trashed');
        Route::get('/{user}', [ModelerController::class, 'show'])->name('modeler.show');
        Route::put('/{user}', [ModelerController::class, 'update'])->name('modeler.update');
        Route::delete('/{user}', [ModelerController::class, 'destroy'])->name('modeler.destroy');
        Route::put('/restore/{user}', [ModelerController::class, 'restore'])->name('modeler.restore');
        Route::delete('forcedelete/{user}', [ModelerController::class, 'deleteForce'])->name('modeler.delete');
    });

    Route::group(['prefix'=>'finance'],function($router){
        Route::get('/', [FinanceController::class, 'index'])->name('finance.index');
        Route::post('/', [FinanceController::class, 'create'])->name('finance.create');
        Route::get('/trashed', [FinanceController::class, 'trashed'])->name('finance.trashed');
        Route::get('/{user}', [FinanceController::class, 'show'])->name('finance.show');
        Route::put('/{user}', [FinanceController::class, 'update'])->name('finance.update');
        Route::delete('/{user}', [FinanceController::class, 'destroy'])->name('finance.destroy');
        Route::put('/restore/{user}', [FinanceController::class, 'restore'])->name('finance.restore');
        Route::delete('forcedelete/{user}', [FinanceController::class, 'deleteForce'])->name('finance.delete');
    });

    Route::group(['prefix' =>'user'], function($router){
        Route::get('/trashed', [UserController::class, 'trashed'])->name('user.trashe');
        Route::post('/', [UserController::class, 'create'])->name('user.create');
        Route::put('/restore/{user}', [UserController::class, 'restore'])->name('user.restore');
        Route::delete('/user/forcedelete/{user}', [UserController::class, 'deleteForce'])->name('user.delete');
    });

    Route::post('admin/logout', [AdminLoginController::class, 'adminLogout'])->name('admin.logout');

});
