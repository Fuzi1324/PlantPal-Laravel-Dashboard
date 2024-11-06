<?php

namespace App\Livewire;

use Livewire\Component;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MQTTLivewireSend extends Component
{
    public $message = '';

    public function sendDownlink()
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

            $applicationId = 'plant-pal@ttn'; // Ersetze durch deine Anwendungs-ID
            $deviceId = '0001-plant-00-00'; // Ersetze durch die Device-ID deines Geräts

            $topic = "v3/{$applicationId}/devices/{$deviceId}/down/push";

            $message = [
                'downlinks' => [
                    [
                        'f_port' => 15,
                        'frm_payload' => base64_encode('Hello, Device!'),
                        'priority' => 'NORMAL',
                    ],
                ],
            ];

            $mqtt->publish($topic, json_encode($message), 0);

            $mqtt->disconnect();
        } catch (\Exception $e) {
            dd('Verbindungsfehler: ' . $e->getMessage());
        }
    }

    public function sendMessage()
    {
        $this->sendDownlink();
    }



    public function render()
    {
        return view('livewire.MQTT-livewire-send');
    }
}
