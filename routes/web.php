<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use DragonCode\Contracts\Cashier\Config\Queues\Names;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReportMapController;

 
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () { 
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [UsuarioController::class, 'profile'])->name('profile');
    Route::resource('/usuarios', AdministradorController::class)->names('admins');
    Route::resource('/ciudadanos', CitizenController::class)->names('citizens');
    Route::resource('/roles', RoleController::class)->names('roles');
    Route::resource('/reportes', ReportsController::class)->names('reportes');

    Route::get('/reportes/getReportes', [ReportsController::class, 'show'])->name('reportes.show');

    Route::get('/backup', [BackupController::class, 'Backup'])->name('backup');

    Route::get('/mapa', [MapController::class, 'mostrarMapa'])->name('maps');

    Route::get('/reporte/mapa/{id}', [ReportMapController::class, 'mostrarReporteMapa'])->name('reporte.mapa');

});

