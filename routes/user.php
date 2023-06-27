<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserLoginController;


Route::post('user/login', [UserLoginController::class, 'userLogin'])->name('user.login');

Route::group( ['prefix'=> 'user', 'middleware' =>['auth:user-api', 'scope:user'] ], function(){
    Route::post('dashboard', [UserLoginController::class, 'userDashboard'])->name('user.dashboard');
});
