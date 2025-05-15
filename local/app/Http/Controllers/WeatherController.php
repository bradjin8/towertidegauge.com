<?php

namespace App\Http\Controllers;

use App\Models\TideGauge;
use App\Models\Weather;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index()
    {
        $weathers = Weather::all();
        return view('weather.index', compact('weathers'));
    }

    public function create()
    {
        return view('weather.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial' => 'required|string',
            'header' => 'required|string|max:255',
            '_date' => 'required|string|max:255',
            '_time' => 'required|string|max:255',
            'barometric_pressure_inches' => 'required|numeric',
            'barometric_pressure_mm' => 'required|numeric',
            'air_temperature' => 'required|numeric',
            'water_temperature' => 'required|numeric',
            'relative_humidity' => 'required|numeric',
            'absolute_humidity' => 'required|numeric',
            'dew_point' => 'required|numeric',
            'wind_direction_true' => 'required|numeric',
            'wind_direction_mg' => 'required|numeric',
            'wind_speed_kts' => 'required|numeric',
            'wind_speed_mps' => 'required|numeric',
        ]);

        $tideGauge = TideGauge::query()->where('_serial', $request->get('serial'))->first();
        if (!$tideGauge) {
            return redirect()->route('weather.create')
                ->with('error', 'Tide Gauge with this serial not found.');
        }
        $data = $request->all();
        $data['tidegauge_id'] = $tideGauge->id;
        $tideGauge->weathers()->create($data);

        return redirect()->route('weather.index')
            ->with('success', 'Weather data added successfully.');
    }

    public function edit(String $id)
    {
        $weather = Weather::find($id);
        if (!$weather) {
            return redirect()->route('weather.index')
                ->with('error', 'Weather data not found.');
        }

        return view('weather.edit', compact('weather'));
    }

    public function update(Request $request, String $id)
    {
        $weather = Weather::find($id);
        if (!$weather) {
            return redirect()->route('weather.index')
                ->with('error', 'Weather data not found.');
        }
        $request->validate([
            'header' => 'required|string|max:255',
            '_date' => 'required|string|max:255',
            '_time' => 'required|string|max:255',
            'barometric_pressure_inches' => 'required|numeric',
            'barometric_pressure_mm' => 'required|numeric',
            'air_temperature' => 'required|numeric',
            'water_temperature' => 'required|numeric',
            'relative_humidity' => 'required|numeric',
            'absolute_humidity' => 'required|numeric',
            'dew_point' => 'required|numeric',
            'wind_direction_true' => 'required|numeric',
            'wind_direction_mg' => 'required|numeric',
            'wind_speed_kts' => 'required|numeric',
            'wind_speed_mps' => 'required|numeric',
        ]);

        $weather->update($request->all());

        return redirect()->route('weather.index')
            ->with('success', 'Weather data updated successfully.');
    }

    public function destroy(String $id)
    {
        $weather = Weather::find($id);
        if (!$weather) {
            return redirect()->route('weather.index')
                ->with('error', 'Weather data not found.');
        }
        $tideGauge = $weather->tideGauge;
        $weather->delete();

        return redirect()->route('weather.index')
            ->with('success', 'Weather data deleted successfully.');
    }
}
