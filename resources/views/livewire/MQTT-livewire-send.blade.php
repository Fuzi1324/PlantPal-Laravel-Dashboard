<div>
    <h2>Nachricht an Gerät: {{ $deviceId }}</h2>
    <input type="text" wire:model="message" placeholder="Nachricht eingeben">
    <button wire:click="sendMessage">Nachricht senden</button>

    @if (session()->has('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif
</div>
