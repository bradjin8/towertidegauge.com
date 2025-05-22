<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeviceSettings;
use App\Models\WeatherData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceSettingsController extends Controller
{
    // Fetch all tide gauges
    public function index(): \Illuminate\Http\JsonResponse
    {
        $items = DeviceSettings::all();
        return response()->json($items);
    }

    // Fetch a tide gauge by Serial
    public function show($serial)
    {
        $item = DeviceSettings::query()->where('serial', $serial)->first();
        if (!$item) {
            return response()->json(['error' => 'Device settings not found'], 404);
        }

        return response()->json($item);
    }

    public function store(Request $request)
    {
        $serial = $request->get('SerialNumber');
        if (!$serial) {
            return response()->json(['error' => 'Invalid data'], 400);
        }

        DeviceSettings::create([
            'serial' => $serial,
            'settings_json' => json_encode($request->all()),
        ]);

        return response()->json(['success' => true]);
    }
}
