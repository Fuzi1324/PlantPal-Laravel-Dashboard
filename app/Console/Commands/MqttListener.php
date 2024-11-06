<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\MqttMessage;

class MqttListener extends Command
{
    protected $signature = 'mqtt:listen';

    protected $description = 'Listens to MQTT messages and stores them in the database';

    public function handle()
    {
        $server   = env('MQTT_HOST');
        $port     = env('MQTT_PORT');
        $clientId = env('MQTT_CLIENT_ID') . '_listener';
        $username = env('MQTT_USERNAME');
        $password = env('MQTT_PASSWORD');

        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true);

        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            $mqtt->connect($connectionSettings, true);

            $topic = 'v3/+/devices/+/up'; // Abonniere alle Uplink-Nachrichten

            $mqtt->subscribe($topic, function ($topic, $message) {
                // Nachricht in der Datenbank speichern

                // Optionale Extraktion von Anwendungs-ID und Geräte-ID aus dem Thema
                $pattern = '/v3\/([^\/]+)\/devices\/([^\/]+)\/up/';
                preg_match($pattern, $topic, $matches);

                $applicationId = $matches[1] ?? null;
                $deviceId = $matches[2] ?? null;

                // Nachricht dekodieren
                $payload = json_decode($message, true);

                // Erstelle einen neuen Datenbankeintrag
                MqttMessage::create([
                    'application_id' => $applicationId,
                    'device_id' => $deviceId,
                    'topic' => $topic,
                    'payload' => $payload,
                ]);
            }, 0);

            $mqtt->loop(true); // Dauerschleife zum Empfangen von Nachrichten

            $mqtt->disconnect();
        } catch (\Exception $e) {
            $this->error('Verbindungsfehler: ' . $e->getMessage());
        }
    }
}
