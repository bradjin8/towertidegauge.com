<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TideGauge;

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
}
