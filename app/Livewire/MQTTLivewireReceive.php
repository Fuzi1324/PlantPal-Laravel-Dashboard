<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MqttMessage;
use Carbon\Carbon;

class MQTTLivewireReceive extends Component
{
    public $deviceId;
    public $messages = [];

    public function mount($deviceId)
    {
        $this->deviceId = $deviceId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);

        $this->messages = MqttMessage::where('device_id', $this->deviceId)
            ->where('created_at', '>=', $sevenDaysAgo)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) {
                return $message->created_at->format('Y-m-d');
            })
            ->map(function ($dayMessages) {
                return $dayMessages->toArray();
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.MQTT-livewire-receive', [
            'messages' => $this->messages,
        ]);
    }
}
