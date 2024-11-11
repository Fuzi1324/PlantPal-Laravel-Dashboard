<x-app-layout>
    <h1>My Devices</h1>
    <ul>
        @foreach ($devices as $device)
            <li>
                <a href="{{ route('devices.show', $device->id) }}">
                    {{ $device->device_id }}
                </a>
            </li>
        @endforeach
    </ul>
</x-app-layout>
