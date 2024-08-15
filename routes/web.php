<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use DragonCode\Contracts\Cashier\Config\Queues\Names;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;

 
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () { 
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [UsuarioController::class, 'profile'])->name('dashboard');
    Route::resource('/administradores', ClienteController::class)->names('administradores');
    Route::resource('/admins', AdministradorController::class)->names('admins');
    Route::resource('/roles', RoleController::class)->names('roles');
    Route::resource('/permisos', PermisoController::class)->names('permisos');
});

