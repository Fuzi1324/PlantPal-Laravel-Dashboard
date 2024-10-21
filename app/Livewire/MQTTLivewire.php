<?php

namespace App\Livewire;

use Livewire\Component;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MQTTLivewire extends Component
{
    public $message = '';

    public function mount()
    {
        $this->connectToMqtt();
    }

    public function connectToMqtt()
    {
        $server   = env('MQTT_HOST');
        $port     = env('MQTT_PORT');
        $clientId = env('MQTT_CLIENT_ID');
        $username = env('MQTT_USERNAME');
        $password = env('MQTT_PASSWORD');

        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true);

        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            $mqtt->connect($connectionSettings, true);

            $mqtt->subscribe('PlantPal/00001', function ($topic, $message) {
                // Nachricht verarbeiten
                // Zum Beispiel die Nachricht in einer Komponenteneigenschaft speichern
                $this->message = $message;
            }, 0);

            $mqtt->loop(true);

            $mqtt->disconnect();
        } catch (\Exception $e) {
            // Fehlerbehandlung
            dd('Verbindungsfehler: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.MQTT-livewire');
    }
}
