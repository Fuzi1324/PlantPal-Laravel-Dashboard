<x-app-layout>
    <div class="container">
        <h1>Add New Installation</h1>
        <form action="{{ route('installations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="qr_code">Enter QR Code or Installation ID</label>
                <input type="text" name="qr_code" id="qr_code" class="form-control" required>
            </div>
            <div id="qr-reader" style="width:500px"></div>
            <button type="submit" class="btn btn-success">Add Installation</button>
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
