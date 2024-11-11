<div wire:poll.5s="loadMessages">
    <h2>Messages from Device: {{ $deviceId }}</h2>

    @foreach ($messages as $date => $dayMessages)
        <h3>{{ $date }}</h3>
        <ul>
            @foreach ($dayMessages as $message)
                <li>
                    <strong>{{ $message['created_at'] }}:</strong>
                    {{ json_encode($message['payload']) }}
                </li>
            @endforeach
        </ul>
    @endforeach
</div>
