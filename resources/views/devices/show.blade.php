<x-app-layout>
    <div>
        <h2 id="device-details">Plant Details: {{ $device->device_id }}</h2>
            <div class="plant-container">
                <img src="{{ asset('images/water_drop.png') }}" alt="Drop Image" class="drippy-image">
                <p>@livewire('mqtt-livewire-receive', ['deviceId' => $device->device_id])</p>
                <img src="{{ asset('images/plant.png') }}" alt="Plant Image" class="plant-image">
            </div>
        @livewire('mqtt-livewire-send', ['deviceId' => $device->device_id])
    </div>
</x-app-layout>
