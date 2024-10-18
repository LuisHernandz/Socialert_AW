<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ReportMapController extends Controller
{
    public function mostrarReporteMapa($id)
    {
        $reporte = DB::table('reports')->where('id', $id)->first();

        if (!$reporte) {
            return redirect()->route('reportes.index')->with('error', 'Reporte no encontrado.');
        }

        $apiUrl = 'https://us1.locationiq.com/v1/reverse.php';
        $response = Http::get($apiUrl, [
            'key' => 'PK.90D9F6413C929B1020B3A3533ADB44AC',
            'lat' => $reporte->latitude,
            'lon' => $reporte->longitude,
            'format' => 'json',
            'accept-language' => 'es',
        ]);

        $data = $response->json();

        if ($response->ok() && isset($data['display_name'])) {
            $reporte->address = $data['display_name'];
        } else {
            $reporte->address = 'Dirección no disponible';
        }

        return view('maps.reporte_mapa', compact('reporte'));
    }
}
