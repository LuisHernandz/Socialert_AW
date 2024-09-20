<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    public function Backup()
    {
        $fecha = date('d-m-Y');
        $nombreArchivo = 'Backup-SOCIALERT' . $fecha . '.zip';
        
        Artisan::call('backup:run', ['--only-db' => true, '--filename' => $nombreArchivo]);

        Log::info('Backup ejecutado con nombre de archivo: ' . $nombreArchivo);

        $rutaArchivo = storage_path('app/Laravel/' . $nombreArchivo);

        if (Storage::exists('Laravel/' . $nombreArchivo)) {
            Log::info('Archivo encontrado: ' . $rutaArchivo);
            return response()->download($rutaArchivo)->deleteFileAfterSend();
        } else {
            Log::info('Archivo no encontrado: ' . $rutaArchivo);
            return response()->json(['message' => 'Backup file not found.'], 404);
        }
    }
}
