<?php

use App\Http\Controllers\Auth\FinancialLoginController;
use Illuminate\Support\Facades\Route;

Route::post('financial/login', [FinancialLoginController::class, 'financialLogin'])->name('financial.login');

Route::group( ['prefix'=> 'financial', 'middleware' =>['auth:financial-api', 'scope:financial'] ], function(){
    Route::post('dashboard', [FinancialLoginController::class, 'financialDashboard'])->name('financial.dashboard');
});
