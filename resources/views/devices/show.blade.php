@extends('layout.mainLayout')

@section('content')
    <h1>Gerät: {{ $device->name ?? $device->device_id }}</h1>

    @livewire('m-q-t-t-livewire-send', ['deviceId' => $device->device_id])
    @livewire('m-q-t-t-livewire-receive', ['deviceId' => $device->device_id])
@endsection
