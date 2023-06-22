<?php

use App\Http\Controllers\AuthController;
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
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
Route::controller(AuthController::class)->group(function(){
    Route::group(['prefix'=>'user'],
        function($router){
            Route::get('details', 'getUserDetail');
            Route::post('logout', 'logout');

        });
})->middleware('auth:api');

// Route::middleware('auth:api')->group(function () {
//     Route::post('/logout', 'AuthController@logout');
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
// });
