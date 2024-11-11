<?php

namespace App\Livewire;

use Livewire\Component;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\Device;

class MQTTLivewireSend extends Component
{
    public $deviceId;
    public $applicationId;
    public $message = '';

    public function mount($deviceId)
    {
        $device = Device::where('device_id', $deviceId)->firstOrFail();
        $this->deviceId = $device->device_id;
        $this->applicationId = $device->application_id;
        $this->message = "The Plant has to be watered. Device ID: {$device->device_id}.";
    }

    public function sendDownlink()
    {
        $server   = env('MQTT_HOST');
        $port     = env('MQTT_PORT');
        $clientId = env('MQTT_CLIENT_ID') . '_downlink_sender';
        $username = env('MQTT_USERNAME');
        $password = env('MQTT_PASSWORD');

        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true);

        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            $mqtt->connect($connectionSettings, true);

            $topic = "v3/{$this->applicationId}@ttn/devices/{$this->deviceId}/down/push";

            $message = [
                'downlinks' => [
                    [
                        'f_port' => 15,
                        'frm_payload' => base64_encode($this->message),
                        'priority' => 'NORMAL',
                    ],
                ],
            ];

            $mqtt->publish($topic, json_encode($message), 0);
            $mqtt->disconnect();
        } catch (\Exception $e) {
            session()->flash('error', 'Connection error: ' . $e->getMessage());
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
