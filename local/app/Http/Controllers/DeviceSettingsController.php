<?php

namespace App\Http\Controllers;

use App\Models\DeviceSettings;

class DeviceSettingsController extends Controller
{
    public function index()
    {
        $settings = DeviceSettings::all();

        return view('device_settings.index', compact('settings'));
    }

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
