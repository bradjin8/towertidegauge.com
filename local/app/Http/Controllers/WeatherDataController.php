<?php

namespace App\Http\Controllers;

use App\Models\TideGauge;
use App\Models\Weather;
use App\Models\WeatherData;
use Illuminate\Http\Request;

class WeatherDataController extends Controller
{
    public function index(Request $request)
    {
        $serials = WeatherData::query()
            ->select('serial')
            ->distinct()
            ->groupBy('serial')
            ->get();

        $query = WeatherData::query();

        if ($serial = $request->query('serial')) {
            $query->where('serial', $serial);
        }

        $weathers = $query
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('weatherdata.index', compact('weathers', 'serials'));
    }

    public function create()
    {
        return view('weather.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial' => 'required|string',
            'time' => 'required|string|max:255',
            'wind_direction' => 'required|numeric',
            'wind_speed' => 'required|numeric',
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'pressure' => 'required|numeric',
        ]);

        $tideGauge = TideGauge::query()->where('_serial', $request->get('serial'))->first();
        if (!$tideGauge) {
            return redirect()->route('weather.create')
                ->with('error', 'Tide Gauge with this serial not found.');
        }
        WeatherData::create($request->all());

        return redirect()->route('weatherdata.index')
            ->with('success', 'Weather data added successfully.');
    }

    public function edit(String $id)
    {
        $weather = WeatherData::find($id);
        if (!$weather) {
            return redirect()->route('weatherdata.index')
                ->with('error', 'Weather data not found.');
        }

        return view('weather.edit', compact('weather'));
    }

    public function update(Request $request, String $id)
    {
        $weather = WeatherData::find($id);
        if (!$weather) {
            return redirect()->route('weather.index')
                ->with('error', 'Weather data not found.');
        }
        $request->validate([
            'serial' => 'required|string',
            'time' => 'required|string|max:255',
            'wind_direction' => 'required|numeric',
            'wind_speed' => 'required|numeric',
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'pressure' => 'required|numeric',
        ]);

        $weather->update($request->all());

        return redirect()->route('weatherdata.index')
            ->with('success', 'Weather data updated successfully.');
    }

    public function destroy(String $id)
    {
        $weather = WeatherData::find($id);
        if (!$weather) {
            return redirect()->route('weatherdata.index')
                ->with('error', 'Weather data not found.');
        }
        $weather->delete();

        return redirect()->route('weatherdata.index')
            ->with('success', 'Weather data deleted successfully.');
    }
}
