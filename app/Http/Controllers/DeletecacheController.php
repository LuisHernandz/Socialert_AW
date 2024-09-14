<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DeletecacheController extends Controller
{
    //
    public function almacenarCache()
    {
        Cache::put('clave_cache', 'algun valor', 2); // Almacena por 2 segundos
        return 'Valor almacenado en caché.';
    }

    public function verificarCache()
    {
        $valor = Cache::get('clave_cache');

        if ($valor) {
            return 'Cache is still valid: ' . $valor;
        } else {
            return 'Cache has expired or does not exist.';
        }
    }
}
