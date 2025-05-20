<?php

namespace App\Http\Controllers;

use App\Models\DeviceSettings;
use App\Models\Measurement;
use App\Models\TideGauge;
use Illuminate\Http\Request;

class DeviceSettingsController extends Controller
{
    public function view(String $serial)
    {
        $settings = DeviceSettings::query()->where('serial', $serial)->first();
        if (!$settings) {
            $json = '{}';
        } else {
            $json = $settings->settings_json;
        }

        return view('device_settings.view', compact('serial', 'json'));
    }
}
