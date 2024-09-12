<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiCitizenController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/show-citizen/{id}', [ApiCitizenController::class, 'show']);

Route::post('/store-citizen', [ApiCitizenController::class, 'store']);

Route::post('/update-citizen/{id}', [ApiCitizenController::class, 'update']);

Route::delete('/destroy-citizen/{id}', [ApiCitizenController::class, 'destroy']);

Route::post('/login-citizen', [ApiCitizenController::class, 'login_citizen']);

Route::middleware('auth:sanctum') -> group(function(){
    Route::post('/logout-citizen', [ApiCitizenController::class, 'logout_citizen']);
});
