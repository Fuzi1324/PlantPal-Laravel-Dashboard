<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\MqttMessage;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Auth::user()->devices;
        return view('devices.index', compact('devices'));
    }


    public function show(Device $device)
    {
        $messages = MqttMessage::where('device_id', $device->id)
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at')
            ->get();
        return view('devices.show', compact('device'));
    }
}
