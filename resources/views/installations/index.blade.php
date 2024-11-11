<x-app-layout>
    <div class="main-container">
        <div class="installation-overview">
            <!-- Schleife für vorhandene Installationen -->
            @foreach ($installations as $installation)
                <div class="installation-card">
                    <a href="{{ route('installations.show', $installation) }}">
                        <img src="path/to/installation-image.png" alt="Installation Image">
                        <h3>{{ $installation->name ?? 'Anlage ' . $loop->iteration }}</h3>
                    </a>
                </div>
            @endforeach

            <div class="installation-card add-device-card">
                <form action="{{ route('installations.store') }}" method="POST" class="qr-scanner-section">
                    @csrf
                    <input type="hidden" name="qr_code" id="qr_code">

                    <div id="qr-reader" class="qr-scanner"></div>
                    <button type="submit" class="add-installation-button">
                        + Add Installation
                    </button>
                </form>
            </div>
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
