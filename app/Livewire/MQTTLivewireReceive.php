<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MqttMessage;
use App\Models\Device;

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
        $this->messages = MqttMessage::where('device_id', $this->deviceId)
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();
    }

    public function render()
    {
        return view('livewire.MQTT-livewire-receive');
    }
}
