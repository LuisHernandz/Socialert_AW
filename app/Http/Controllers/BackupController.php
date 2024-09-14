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
        
        // Llamada al comando Artisan de forma interna, sin necesidad de exec()
        Artisan::call('backup:run', ['--only-db' => true, '--filename' => $nombreArchivo]);

        // Registrar salida en los logs
        Log::info('Backup ejecutado con nombre de archivo: ' . $nombreArchivo);

        // Verificar la ruta del archivo
        $rutaArchivo = storage_path('app/Laravel/' . $nombreArchivo);

        // Verificar si el archivo existe
        if (Storage::exists('Laravel/' . $nombreArchivo)) {
            Log::info('Archivo encontrado: ' . $rutaArchivo);
            return response()->download($rutaArchivo)->deleteFileAfterSend();
        } else {
            Log::info('Archivo no encontrado: ' . $rutaArchivo);
            return response()->json(['message' => 'Backup file not found.'], 404);
        }
    }
}
