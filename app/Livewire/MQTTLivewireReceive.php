<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MqttMessage;

class MQTTLivewireReceive extends Component
{

    public $messages = [];

    public function mount()
    {
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = MqttMessage::orderBy('created_at', 'desc')->take(50)->get();
    }

    public function render()
    {
        return view('livewire.MQTT-livewire-receive');
    }
}
