<!-- installations/show.blade.php -->
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Plants in {{ $installation->name }}</h2>

        <div class="plant-grid">
            @foreach ($plants as $plant)
                <div class="plant-item">
                    <div class="PlantandDevice">
                        <h3 class="PlantDevice">
                            {{ $plant->name ?? 'Plant ' . ($plant->sensor_index + 1) }}
                        </h3>
                        <span class="device-name">
                            Device: {{ $plant->device_id }}
                        </span>
                    </div>

                    <div class="Plant-info">
                        <button onclick="window.location.href='{{ route('devices.show', $plant->device->id) }}'" class="info-button">
                            <div class="MoistureLevel">
                                <span class="text-gray-600"><img src="{{ asset('images/water_drop.png') }}" alt="Drop Image" class="droplet"></span>
                                <span
                                    class="font-medium {{ $plant->last_moisture < 30 ? 'text-red-500' : 'text-green-500' }}">
                                    {{ $plant->last_moisture }}%
                                </span>
                            </div>

                        <div class="LastUpdate">
                            <span class="text-gray-600">Updated: </span>
                            <span class="text-sm text-gray-500">
                                {{ $plant->last_message_at ? $plant->last_message_at->diffForHumans() : 'Never' }}
                            </span>
                        </div>

                        </button>


                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4">Add Device</h3>
            <form action="{{ route('installations.addDevice', $installation) }}" method="POST">
                @csrf
                <div class="qr-box">
                    <div>
                        <label for="qr_code" class="block text-sm font-medium text-gray-700">
                            Enter QR Code or Device ID
                        </label>
                        <input type="text" name="qr_code" id="qr_code"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            required>
                    </div>

                    <div id="qr-reader" class="w-full max-w-lg"></div>

                    <button type="submit"
                        class="addDevice-button">
                        Add Device
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('qr_code').value = decodedText;
            html5QrcodeScanner.clear();
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</x-app-layout>
