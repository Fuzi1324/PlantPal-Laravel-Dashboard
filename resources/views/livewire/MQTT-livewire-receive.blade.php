<div wire:poll.5s="loadMessages">
    <h2>Nachrichten von Gerät: {{ $deviceId }}</h2>
    <ul>
        @foreach ($messages as $message)
            <li>
                <strong>{{ $message->created_at }}:</strong>
                {{ json_encode($message->payload) }}
            </li>
        @endforeach
    </ul>
</div>
