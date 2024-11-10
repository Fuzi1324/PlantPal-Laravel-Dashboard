<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Auth::user()->devices;
        return view('devices.index', compact('devices'));
    }


    public function show(Device $device)
    {
        if ($device->user_id !== Auth::user()->id) {
            abort(403, 'Unberechtigter Zugriff auf dieses Gerät.');
        }

        return view('devices.show', compact('device'));
    }

    public function store(Request $request)
    {
        $qrData = $request->input('qr_code');

        $deviceData = $this->parseQrCode($qrData);

        Device::create([
            'user_id' => Auth::user()->id,
            'device_id' => $deviceData['device_id'],
            'application_id' => $deviceData['application_id'],
            'name' => $deviceData['name'] ?? null,
        ]);

        return redirect()->route('devices.index')->with('success', 'Gerät erfolgreich hinzugefügt.');
    }

    private function parseQrCode($qrData)
    {
        // Implementiere die Logik zum Parsen des QR-Codes
        // Beispiel:
        // return [
        //     'device_id' => '...',
        //     'application_id' => '...',
        //     'name' => '...'
        // ];
    }
}
