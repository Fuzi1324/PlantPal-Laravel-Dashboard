<x-app-layout>
    <div>
        <h2>Device Details: {{ $device->device_id }}</h2>
        @livewire('mqtt-livewire-send', ['deviceId' => $device->device_id])
        @livewire('mqtt-livewire-receive', ['deviceId' => $device->device_id])
    </div>
</x-app-layout>
