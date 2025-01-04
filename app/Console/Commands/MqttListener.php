<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\MqttMessage;
use App\Models\Plant;
use Carbon\Carbon;

class MqttListener extends Command
{
    protected $signature = 'mqtt:listen';

    protected $description = 'Listens to MQTT messages and stores them in the database';

    private function processSensorData($deviceId, $payload)
    {
        if (!isset($payload['uplink_message']['decoded_payload']['sensors'])) {
            return;
        }

        $sensors = $payload['uplink_message']['decoded_payload']['sensors'];
        $timestamp = isset($payload['received_at'])
            ? Carbon::parse($payload['received_at'])
            : now();

        foreach ($sensors as $sensor) {
            if (isset($sensor['id']) && isset($sensor['moisture'])) {
                $sensorIndex = $sensor['id'] - 1;

                Plant::updateOrCreate(
                    [
                        'device_id' => $deviceId,
                        'sensor_index' => $sensorIndex
                    ],
                    [
                        'last_moisture' => floatval($sensor['moisture']),
                        'last_message_at' => $timestamp
                    ]
                );
            }
        }
    }

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

            $topic = 'v3/+/devices/+/up';

            $mqtt->subscribe($topic, function ($topic, $message) {
                $payload = json_decode($message, true);

                if (!$payload || !isset($payload['end_device_ids'])) {
                    return;
                }

                $deviceId = $payload['end_device_ids']['device_id'];
                $applicationId = $payload['end_device_ids']['application_ids']['application_id'];

                $this->processSensorData($deviceId, $payload);

                $existingMessagesCount = MqttMessage::where('device_id', $deviceId)
                    ->whereDate('created_at', now()->toDateString())
                    ->count();

                if ($existingMessagesCount < 2) {
                    MqttMessage::create([
                        'application_id' => $applicationId,
                        'device_id' => $deviceId,
                        'topic' => $topic,
                        'payload' => $payload,
                    ]);
                }
            }, 0);

            $mqtt->loop(true);
            $mqtt->disconnect();
        } catch (\Exception $e) {
            $this->error('Connection error: ' . $e->getMessage());
        }
    }
}
