<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MapController extends Controller
{
    public function mostrarMapa()
    {

        $locations = DB::table('reports')->get();

        foreach ($locations as $location) {

            $apiUrl = 'https://api.distancematrix.ai/maps/api/geocode/json';
            $response = Http::get($apiUrl, [
                'latlng' => $location->latitude . ',' . $location->longitude,
                'language' => 'es',
                'key' => 'SA7O98LM2XpeP1ITwhEdARwdOJONxkLYkkhsGjk2YF0M9ADZQAxC1LxLBqujOdsF' 
            ]);

            $data = $response->json();

            if ($response->ok() && isset($data['result']) && count($data['result']) > 0) {

                $location->address = $data['result'][0]['formatted_address'];
            } else {

                $location->address = 'Dirección no disponible';
            }
        }

        return view('maps.maps', compact('locations'));
    }
}
