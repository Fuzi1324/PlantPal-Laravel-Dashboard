<div wire:poll.5s="loadMessages">

    @if (!empty($messages))
        @php
            $latestMessage = collect($messages)->first();
            $latestEntry = collect($latestMessage)->first();
            $moistureValues = array_values($latestEntry['payload']['uplink_message']['decoded_payload']['moisture_sensors'] ?? []);
        @endphp

        <p id="moisture-value" >{{ implode(', ', $moistureValues) }}%</p>
    @endif
</div>
