<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TideGauge;
use Illuminate\Http\Request;

class TideGaugeController extends Controller
{
    // Fetch all tide gauges
    public function index(): \Illuminate\Http\JsonResponse
    {
        $tideGauges = TideGauge::all();
        return response()->json($tideGauges);
    }

    // Fetch a tide gauge by ID
    public function show($id) {
        $tideGauge = TideGauge::find($id);
        if (!$tideGauge) {
            return response()->json(['error' => 'Tide gauge not found'], 404);
        }

        return response()->json($tideGauge);
    }

    // Fetch a tide gauge by _serial
    public function getItemsBySerial($serial)
    {
        $item = TideGauge::query(['_serial' => $serial])->orderBy('id', 'desc')->get();
        if (!$item) {
            return response()->json(['error' => 'Tide gauge not found'], 404);
        }
        return response()->json($item);
    }

    // Store a new tide gauge
    public function store(Request $request)
    {
        $request->validate([
            '_currenttidestring' => 'required|string|max:255',
        ]);

        $data = $request->get('_currenttidestring');
        $snippets = explode(',', $data);
        if (count($snippets) !== 10) {
            return response()->json(['error' => 'Invalid data'], 400);
        }
        $serial = $snippets[1];

        $date = $snippets[6];
        $time = $snippets[7];
        $tide = $snippets[8];
        $units = $snippets[9];

        $tideGauge = TideGauge::query(['_serial' => $serial])->first();
        if (!$tideGauge) {
            $country = $snippets[2];
            $loc = $snippets[3];
            $lat = $snippets[4];
            $lon = $snippets[5];

            $tideGauge = TideGauge::create([
                '_serial' => $serial,
                '_country' => $country,
                '_loc' => $loc,
                '_lat' => $lat,
                '_lon' => $lon,
            ]);
        }

        $tideGauge->measurements()->create([
            '_date' => $date,
            '_time' => $time,
            '_tide' => $tide,
            '_units' => $units,
        ]);

        return response()->json($tideGauge, 201);
    }
}
