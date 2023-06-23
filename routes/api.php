<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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

// Route::get('/401', [AuthController::class, 'unauthorized'])->name('unauthorized');

Route::group(['prefix' => 'auth'], function(){
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::post('/register', [AuthController::class, 'register'])->name('register');
});



Route::middleware('auth:api')->group(function(){
    Route::group(['prefix' =>'user'], function($router){
        Route::get('/', [UserController::class, 'getDetails']);
        Route::get('/trashed', [UserController::class, 'trashed'])->name('UserTrashed');
        Route::put('/restore/{user}', [UserController::class, 'restore'])->name('UserRestore');
        Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('UserDestroy');
        Route::delete('/forcedelete/{user}', [UserController::class, 'deleteForce'])->name('UserDelete');
    });

    Route::group(['prefix'=>'admin'],function($router){
        Route::post('/create', [AdminController::class, 'create'])->name('AdminCreate');
        Route::get('/details', [AuthController::class, 'getUserDetail'])->name('AdminDetails');
        Route::get('/readAll', [AdminController::class, 'index'])->name('AdminReadAll');
        Route::get('/{user}', [AdminController::class, 'show'])->name('AdminShow');
        Route::put('/{user}', [AdminController::class, 'update'])->name('AdminUpdate');

    });
})->middleware('can:controll-all');
