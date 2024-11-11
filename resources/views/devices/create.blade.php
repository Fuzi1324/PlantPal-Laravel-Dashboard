<x-app-layout>
    <h1>Gerät hinzufügen</h1>
    <form action="{{ route('devices.store') }}" method="POST">
        @csrf
        <label for="qr_code">QR-Code Daten:</label>
        <input type="text" name="qr_code" id="qr_code" required>
        <button type="submit">Gerät hinzufügen</button>
    </form>
</x-app-layout>
