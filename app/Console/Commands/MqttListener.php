<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\MqttMessage;
use App\Models\Plant;

class MqttListener extends Command
{
    protected $signature = 'mqtt:listen';

    protected $description = 'Listens to MQTT messages and stores them in the database';

    private function processSensorData($deviceId, $payload)
    {
        $sensorData = [
            ['index' => 0, 'moisture' => rand(0, 100)],
            ['index' => 1, 'moisture' => rand(0, 100)],
            ['index' => 2, 'moisture' => rand(0, 100)],
            ['index' => 3, 'moisture' => rand(0, 100)]
        ];

        foreach ($sensorData as $data) {
            Plant::updateOrCreate(
                [
                    'device_id' => $deviceId,
                    'sensor_index' => $data['index']
                ],
                [
                    'last_moisture' => $data['moisture'],
                    'last_message_at' => now()
                ]
            );
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
                $pattern = '/v3\/([^\/]+)\/devices\/([^\/]+)\/up/';
                preg_match($pattern, $topic, $matches);

                $applicationId = $matches[1] ?? null;
                $deviceId = $matches[2] ?? null;

                $payload = json_decode($message, true);

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
