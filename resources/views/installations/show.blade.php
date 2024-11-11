<x-app-layout>
    <div>
        <h2>Devices</h2>
        <ul>
            @foreach ($installation->devices as $device)
                <li>{{ $device->name ?? $device->device_id }}</li>
            @endforeach
        </ul>

        <!-- Form to add a new device -->
        <h3>Add Device</h3>
        <form action="{{ route('installations.addDevice', $installation) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="qr_code">Enter QR Code or Device ID</label>
                <input type="text" name="qr_code" id="qr_code" class="form-control" required>
            </div>
            <div id="qr-reader" style="width:500px"></div>
            <button type="submit" class="btn btn-success">Add Device</button>
        </form>
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
