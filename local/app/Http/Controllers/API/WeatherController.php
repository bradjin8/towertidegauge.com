<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TideGauge;
use App\Models\Weather;
use App\Models\WeatherData;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    // Fetch all tide gauges
    public function index(): \Illuminate\Http\JsonResponse
    {
        $items = Weather::all();
        return response()->json($items);
    }

    // Fetch a tide gauge by ID
    public function show($id) {
        $item = Weather::find($id);
        if (!$item) {
            return response()->json(['error' => 'Weather not found'], 404);
        }

        return response()->json($item);
    }

    // Fetch a tide gauge by _serial
    public function getItemsBySerial($serial)
    {
        $tide = TideGauge::query()->where('_serial', $serial)->first();
        if (!$tide) {
            return response()->json(['error' => 'Serial not found'], 404);
        }
        $items = $tide->weathers->sortByDesc('created_at')->take(50)->values();
        return response()->json(['tideGauge' => $items, 'items' => $items]);
    }

    // Store a new tide gauge
    public function store(Request $request)
    {
        $data = $request->get('weatherstring');
        if (!$data) {
            return response()->json(['error' => 'Weather string not found'], 404);
        }
        $snippets = explode(',', $data);
        if (count($snippets) !== 25) {
            return response()->json(['error' => 'Invalid data'], 400);
        }
        $header = $snippets[0];
        $serial = $snippets[1];
        $date = $snippets[2];
        $time = $snippets[3];

        $barometric_pressure_inches = $snippets[4];
        $barometric_pressure_mm = $snippets[6];

        $air_temperature = $snippets[8];
        $water_temperature = $snippets[10];

        $relative_humidity = $snippets[12];
        $absolute_humidity = $snippets[13];

        $dew_point = $snippets[14];
        $wind_direction_true = $snippets[16];
        $wind_direction_mg = $snippets[18];
        $wind_speed_kts = $snippets[20];
        $wind_speed_mps = $snippets[22];


        $tideGauge = TideGauge::query()->where('_serial', $serial)->first();
        if ($tideGauge == null) {
            return response()->json(['error' => 'Serial not found'], 404);
        }

        $tideGauge->weathers()->create([
            'towergauge_id' => $tideGauge->id,
            'serial' => $serial,
            'header' => $header,
            '_date' => $date,
            '_time' => $time,
            'barometric_pressure_inches' => $barometric_pressure_inches,
            'barometric_pressure_mm' => $barometric_pressure_mm,
            'air_temperature' => $air_temperature,
            'water_temperature' => $water_temperature,
            'relative_humidity' => $relative_humidity,
            'absolute_humidity' => $absolute_humidity,
            'dew_point' => $dew_point,
            'wind_direction_true' => $wind_direction_true,
            'wind_direction_mg' => $wind_direction_mg,
            'wind_speed_kts' => $wind_speed_kts,
            'wind_speed_mps' => $wind_speed_mps,
        ]);

        return response()->json(['success' => true]);
    }

    public function storeAsJSON(Request $request)
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
        }
        ;
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
}
