<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function mostrarMapa()
    {
        $locations = DB::table('reports')->get();

        foreach ($locations as $location) {
            $apiUrl = 'https://us1.locationiq.com/v1/reverse.php';
            $response = Http::get($apiUrl, [
                'lat' => $location->latitude,
                'lon' => $location->longitude,
                'key' => 'PK.90D9F6413C929B1020B3A3533ADB44AC',
                'format' => 'json'
            ]);

            $data = $response->json();

            if ($response->ok() && isset($data['display_name'])) {
                $location->address = $data['display_name'];
            } else {
                $location->address = 'Dirección no disponible';
            }
        }

        return view('maps.maps', compact('locations'));
    }
}
