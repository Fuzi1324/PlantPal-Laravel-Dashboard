<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MqttMessage extends Model
{
    protected $fillable = [
        'application_id',
        'device_id',
        'topic',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
