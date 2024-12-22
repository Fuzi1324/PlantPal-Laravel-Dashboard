<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Installation;
use App\Models\Device;
use App\Models\Plant;
use App\Models\MqttMessage;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        $installations = [];
        for ($i = 1; $i <= 3; $i++) {
            $installations[] = Installation::create([
                'user_id' => $user->id,
                'installation_code' => 'INST' . str_pad($i, 3, '0', STR_PAD_LEFT),
            ]);
        }

        foreach ($installations as $installation) {
            for ($i = 1; $i <= 2; $i++) {
                $device = Device::create([
                    'user_id' => $user->id,
                    'installation_id' => $installation->id,
                    'device_id' => 'DEV' . $installation->id . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'application_id' => 'APP001',
                ]);

                for ($sensorIndex = 0; $sensorIndex < 4; $sensorIndex++) {
                    $plant = Plant::create([
                        'device_id' => $device->device_id,
                        'sensor_index' => $sensorIndex,
                        'name' => "Plant " . ($sensorIndex + 1),
                        'last_moisture' => rand(20, 90),
                        'last_message_at' => now()->subMinutes(rand(5, 60)),
                    ]);

                    for ($day = 0; $day < 7; $day++) {
                        for ($hour = 0; $hour < 24; $hour += 4) {
                            $timestamp = Carbon::now()
                                ->subDays($day)
                                ->startOfDay()
                                ->addHours($hour)
                                ->addMinutes(rand(0, 59));

                            $moisture = rand(20, 90);

                            $payload = [
                                'uplink_message' => [
                                    'decoded_payload' => [
                                        'moisture_sensors' => [
                                            $sensorIndex => $moisture
                                        ],
                                        'battery' => rand(30, 100),
                                        'temperature' => rand(180, 280) / 10
                                    ]
                                ]
                            ];

                            MqttMessage::create([
                                'application_id' => $device->application_id,
                                'device_id' => $device->device_id,
                                'topic' => "v3/{$device->application_id}/devices/{$device->device_id}/up",
                                'payload' => $payload,
                                'created_at' => $timestamp,
                                'updated_at' => $timestamp,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
