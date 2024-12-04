<?php

namespace App\Services;

use Google\Client;

class FcmService
{
    protected $client;
    protected $fcmUrl;

    public function __construct()
    {
        $this->fcmUrl = 'https://fcm.googleapis.com/v1/projects/socialert-7e2cc/messages:send';

        // Configurar el cliente de Google
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('firebase/firebase-key.json')); // Ruta al archivo JSON
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    }

    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        // Obtener el token de acceso
        $accessToken = $this->client->fetchAccessTokenWithAssertion()['access_token'];

        // Construir el payload
        $payload = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data, // Datos adicionales opcionales
            ],
        ];

        // Configurar las cabeceras
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        // Enviar la solicitud
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post($this->fcmUrl, [
                'headers' => $headers,
                'json' => $payload,
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error('Error al enviar notificación: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
