<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Device;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InstallationController extends Controller
{
    public function index()
    {
        $installations = Auth::user()->installations;
        return view('installations.index', compact('installations'));
    }

    public function create()
    {
        return view('installations.create');
    }

    public function show(Installation $installation)
    {
        if (Gate::denies('view', $installation)) {
            abort(403, 'Unauthorized access.');
        }

        $devices = $installation->devices;
        $plants = collect();

        foreach ($devices as $device) {
            $devicePlants = Plant::where('device_id', $device->device_id)
                ->orderBy('sensor_index')
                ->get();
            $plants = $plants->concat($devicePlants);
        }

        return view('installations.show', compact('installation', 'plants'));
    }

    public function store(Request $request)
    {
        try {
            $qrData = $request->input('qr_code');
            $installationData = $this->parseQrCode($qrData);

            $existingInstallation = Installation::where('installation_code', $installationData['installation_code'])
                ->where('user_id', Auth::id())
                ->first();

            if ($existingInstallation) {
                return redirect()->back()->with('error', 'This installation is already registered by any user.');
            }

            $installation = Installation::create([
                'user_id' => Auth::id(),
                'installation_code' => $installationData['installation_code'],
                'name' => $installationData['name'] ?? null,
            ]);

            if (!empty($installationData['devices'])) {
                foreach ($installationData['devices'] as $deviceData) {
                    $existingDevice = Device::where('device_id', $deviceData['device_id'])->first();

                    if ($existingDevice) {
                        $installation->delete();
                        return redirect()->back()->with('error', "The device {$deviceData['device_id']} is already registered.");
                    }

                    $installation->devices()->create([
                        'user_id' => Auth::id(),
                        'device_id' => $deviceData['device_id'],
                        'application_id' => $deviceData['application_id'],
                        'name' => $deviceData['name'] ?? null,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('installations.index')->with('success', 'Installation and devices added successfully.');
    }


    private function parseQrCode($qrData)
    {
        try {
            $data = json_decode($qrData, true);

            if (!$data || !isset($data['installation_code'])) {
                throw new \Exception('Invalid QR code data.');
            }
        } catch (\Exception $e) {
            throw new \Exception('Invalid QR code data.');
        }

        return [
            'installation_code' => $data['installation_code'],
            'devices' => $data['devices'] ?? [],
        ];
    }


    private function parseDeviceQrCode($qrData)
    {
        $data = json_decode($qrData, true);

        if (isset($data['devices']) && is_array($data['devices'])) {
            $devices = [];
            foreach ($data['devices'] as $device) {
                if (!isset($device['device_id']) || !isset($device['application_id'])) {
                    throw new \Exception('Invalid device QR code data.');
                }
                $devices[] = [
                    'device_id' => $device['device_id'],
                    'application_id' => $device['application_id'],
                ];
            }
            return $devices;
        }

        if (!isset($data['device_id']) || !isset($data['application_id'])) {
            throw new \Exception('Invalid device QR code data.');
        }

        return [[
            'device_id' => $data['device_id'],
            'application_id' => $data['application_id'],
        ]];
    }

    public function addDevice(Request $request, Installation $installation)
    {
        try {
            $qrData = $request->input('qr_code');
            $devices = $this->parseDeviceQrCode($qrData);

            foreach ($devices as $deviceData) {
                $existingDevice = Device::where('device_id', $deviceData['device_id'])->first();

                if ($existingDevice) {
                    return redirect()->back()->with('error', "The device {$deviceData['device_id']} is already registered.");
                }

                $installation->devices()->create([
                    'user_id' => Auth::id(),
                    'device_id' => $deviceData['device_id'],
                    'application_id' => $deviceData['application_id'],
                    'name' => $deviceData['name'] ?? null,
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('installations.show', $installation)->with('success', 'Devices added successfully.');
    }
}
