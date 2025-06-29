<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WeatherData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeatherDataController extends Controller
{
    // Fetch all tide gauges
    public function index(): \Illuminate\Http\JsonResponse
    {
        $items = WeatherData::all();
        return response()->json($items);
    }

    // Fetch a tide gauge by ID
    public function show($id)
    {
        $item = WeatherData::find($id);
        if (!$item) {
            return response()->json(['error' => 'Weather not found'], 404);
        }

        return response()->json($item);
    }

    // Fetch a tide gauge by _serial
    public function getItemsBySerial($serial)
    {
        $items = WeatherData::query()
            ->where('serial', $serial)
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return response()->json([
            'tideGauge' => $items,
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->get('weatherstring');
        if (!$data) {
            return response()->json(['error' => 'Weather string not found'], 404);
        }

        $serial = $data['Serial'];
        $time = $data['Time'];
        $windDirection = $data['WindDirection'];
        $windSpeed = $data['WindSpeed'];
        $temperature = $data['Temperature'];
        $humidity = $data['Humidity'];
        $pressure = $data['Pressure'];

        // validate if all are present
        if (
            !$serial || !$time
            || !$windDirection || !$windSpeed || !$temperature || !$humidity || !$pressure
        ) {
            return response()->json(['error' => 'Invalid data'], 400);
        };
        WeatherData::create([
            'serial' => $serial,
            'time' => $time,
            'wind_direction' => $windDirection,
            'wind_speed' => $windSpeed,
            'temperature' => $temperature,
            'humidity' => $humidity,
            'pressure' => $pressure,
        ]);

        return response()->json(['success' => true]);
    }


    public function destroyBySerial($serial)
    {
        if (!$serial) {
//            $serials = DeviceSettings::all();
//            DeviceSettings::destroy($serials);
            return response()->json(['error' => 'Invalid serial'], 400);
        } else {
            DB::table('weather_data')->where('serial', $serial)->delete();
        }
        return response()->json(['success' => true]);
    }
}
