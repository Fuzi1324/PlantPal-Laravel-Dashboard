<x-app-layout>
    <div class="main-container">
        <div class="installation-overview">
            @foreach ($installations as $installation)
                <a href="{{ route('installations.show', $installation) }}" class="installation-card">
                    <img src="{{ asset('images/palette.png') }}" alt="Installation Image" class="installation-image">
                    <h3>{{ $installation->name ?? 'Anlage ' . $loop->iteration }}</h3>
                </a>
            @endforeach

            <div class="installation-card add-device-card">
                <form action="{{ route('installations.store') }}" method="POST" class="qr-scanner-section">
                    @csrf
                    <input type="text" name="qr_code" id="qr_code" class="hidden">
                    <div id="qr-reader"></div>
                    <button type="submit" class="add-installation-button">
                        + Installation hinzufügen
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
            document.querySelector('form').submit();
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 180
            });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</x-app-layout>
