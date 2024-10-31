<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiCitizenController;
use App\Http\Controllers\Api\ApiReportsController;
use App\Http\Controllers\Api\ApiContactsController;
use App\Http\Controllers\Api\ApiProfileController;

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

Route::get('/show-citizen/{id}', [ApiCitizenController::class, 'show']);

Route::post('/store-citizen', [ApiCitizenController::class, 'store']);

Route::post('/update-citizen/{id}', [ApiCitizenController::class, 'update']);

Route::delete('/destroy-citizen/{id}', [ApiCitizenController::class, 'destroy']);

Route::post('/login-citizen', [ApiCitizenController::class, 'login_citizen']);

Route::middleware('auth:sanctum') -> group(function(){
    Route::post('/logout-citizen', [ApiCitizenController::class, 'logout_citizen']);

    //Citizens routes

    //Profile
    Route::get('show-profile',[ApiProfileController::class, 'show']);
    Route::post('update-profile',[ApiProfileController::class, 'update']);
    Route::delete('destroy-profile',[ApiProfileController::class, 'destroy']);


    //Reports routes
    Route::get('/index-reports', [ApiReportsController::class, 'index']);
    Route::get('/show-reports', [ApiReportsController::class, 'show']);
    Route::get('/create-report', [ApiReportsController::class, 'create']);
    Route::post('/store-report', [ApiReportsController::class, 'store']);
    Route::post('/update-report', [ApiReportsController::class, 'update']);
    Route::delete('/destroy-report', [ApiReportsController::class, 'destroy']);

    //Contacts routes
    Route::get('index-contacts', [ApiContactsController::class, 'index']);
    Route::post('store-contact', [ApiContactsController::class, 'store']);
    Route::post('update-contact', [ApiContactsController::class, 'update']);
    Route::delete('destroy-contact', [ApiContactsController::class, 'destroy']);
});







