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
                        <span class="text-sm text-gray-500">
                            Device: {{ $plant->device_id }}
                        </span>
                    </div>

                    <div class="Plant-info">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Moisture Level:</span>
                            <span
                                class="font-medium {{ $plant->last_moisture < 30 ? 'text-red-500' : 'text-green-500' }}">
                                {{ $plant->last_moisture }}%
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="text-sm text-gray-500">
                                {{ $plant->last_message_at ? $plant->last_message_at->diffForHumans() : 'Never' }}
                            </span>
                        </div>

                        <button onclick="window.location.href='{{ route('devices.show', $plant->device->id) }}'"
                            class="w-full bg-green-600 text-white rounded-md py-2 hover:bg-green-700 transition">
                            View Details
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4">Add Device</h3>
            <form action="{{ route('installations.addDevice', $installation) }}" method="POST">
                @csrf
                <div class="Plant-info">
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
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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
