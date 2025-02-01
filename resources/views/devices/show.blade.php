<x-app-layout>
    <div id="device-details">
        <h2>Device Details: {{ $device->device_id }}</h2>
            <div class="plant-container">
                <img src="{{ asset('images/plant.png') }}" alt="Plant Image" class="plant-image">
            </div>
        @livewire('mqtt-livewire-send', ['deviceId' => $device->device_id])
        @livewire('mqtt-livewire-receive', ['deviceId' => $device->device_id])
    </div>
</x-app-layout>
