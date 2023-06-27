<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ModelerLoginController;

Route::post('modeler/login', [ModelerLoginController::class, 'modelerLogin'])->name('modeler.login');

Route::group( ['prefix'=> 'modeler', 'middleware' =>['auth:modeler-api', 'scope:modeler'] ], function(){
    Route::post('dashboard', [ModelerLoginController::class, 'modelerDashboard'])->name('modeler.dashboard');
});
