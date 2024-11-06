<div wire:poll.5s="loadMessages">
    <h1>Empfangene MQTT-Nachrichten</h1>
    <ul>
        @foreach ($messages as $message)
            <li>
                <strong>{{ $message->created_at }}:</strong>
                <strong>AppID:</strong> {{ $message->application_id }} |
                <strong>DeviceID:</strong> {{ $message->device_id }} |
                <strong>Payload:</strong> {{ json_encode($message->payload) }}
            </li>
        @endforeach
    </ul>
</div>
