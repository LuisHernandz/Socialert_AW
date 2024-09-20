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

        $apiUrl = 'https://api.distancematrix.ai/maps/api/geocode/json';
        $response = Http::get($apiUrl, [
            'latlng' => $reporte->latitude . ',' . $reporte->longitude,
            'language' => 'es',
            'key' => 'SA7O98LM2XpeP1ITwhEdARwdOJONxkLYkkhsGjk2YF0M9ADZQAxC1LxLBqujOdsF'
        ]);

        $data = $response->json();

        if ($response->ok() && isset($data['result']) && count($data['result']) > 0) {

            $reporte->address = $data['result'][0]['formatted_address'];
        } else {

            $reporte->address = 'Dirección no disponible';
        }

        return view('maps.reporte_mapa', compact('reporte'));
    }
}
