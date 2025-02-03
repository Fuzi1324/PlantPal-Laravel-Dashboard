<x-app-layout>
    <h1>Add New Device</h1>
    <form action="{{ route('devices.store') }}" method="POST">
        @csrf
        <label for="qr_code">QR-Code Daten:</label>
        <input type="text" name="qr_code" id="qr_code" required>
        <button type="submit">Add Device</button>
    </form>
</x-app-layout>
