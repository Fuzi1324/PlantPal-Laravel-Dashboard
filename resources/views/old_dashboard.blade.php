<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="installation-overview">
        <!-- Existing installations loop -->
        @foreach ($installations as $installation)
            <div class="installation-card">
                <a href="{{ route('installations.show', $installation) }}">
                    <img src="path/to/installation-image.png" alt="Installation Image">
                    <h3>{{ $installation->name ?? 'Anlage ' . $loop->iteration }}</h3>
                </a>
            </div>
        @endforeach

        <!-- Add Installation Card with QR Code Scanner -->
        <div class="installation-card add-device-card">
            <!-- Form to handle POST request for adding installation -->
            <form action="{{ route('installations.store') }}" method="POST">
                @csrf
                <!-- Hidden input to store QR code value -->
                <input type="hidden" name="qr_code" id="qr_code">

                <div id="qr-reader" style="width:500px"></div>

                <button type="submit" class="add-device-link">
                    <div class="add-device-content">
                        <p>+ Add Installation</p>
                    </div>
                </button>
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
