<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    protected $signature = 'mqtt:subscribe';

    protected $description = 'Subscribe to MQTT topic';

    public function handle()
    {
        $mqtt = MQTT::connection();
        $mqtt->subscribe('devices/+/status', function (string $topic, string $message) {
            echo sprintf('Received message on topic [%s]: %s', $topic, $message);
        });

        $mqtt->loop(true);
        return Command::SUCCESS;
        //NNSXS.LFYMTWHYN3246XQS3YNWJGS6VDNUQVLLJKK43NY.FEPPMDLVOBEARFCMRAO77VQAIFJXOME6SGSDIDWW2EOLUE4O2TQA
    }


    public function index()
    {
        $devices = Auth::user()->devices;
        return view('home', compact('devices'));
    }
}
