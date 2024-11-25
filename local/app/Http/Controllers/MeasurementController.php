<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\TideGauge;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function index()
    {
        $measurements = Measurement::all();
        return view('measurement.index', compact('measurements'));
    }

    public function create($id)
    {
        $tideGauge = TideGauge::find($id);
        if (!$tideGauge) {
            return redirect()->route('tidegauges.index')
                ->with('error', 'Tide Gauge not found.');
        }
        return view('measurement.create', compact('tideGauge'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tidegauge_id' => 'required|numeric',
            '_date' => 'required|string|max:255',
            '_time' => 'required|string|max:255',
            '_tide' => 'required|numeric',
            '_units' => 'required|string|max:255',
        ]);

        $tideGauge = TideGauge::find($request->get('tidegauge_id'));
        if (!$tideGauge) {
            return redirect()->route('tidegauges.view', ['id' =>$request->get('tidegauge_id')])
                ->with('error', 'Tide Gauge not found.');
        }
        $tideGauge->measurements()->create($request->all());

        return redirect()->route('tidegauges.view', ['id' => $request->get('tidegauge_id')])
            ->with('success', 'Tide data added successfully.');
    }

    public function edit(String $id)
    {
        $measurement = Measurement::find($id);
        $tideGauge = $measurement->tideGauge;
        if (!$measurement) {
            return redirect()->route('tidegauges.view', ['id' => $tideGauge->id])
                ->with('error', 'Tide data not found.');
        }

        return view('measurement.edit', compact('measurement'));
    }

    public function update(Request $request, String $id)
    {
        $measurement = Measurement::find($id);
        if (!$measurement) {
            return redirect()->route('measurement.index')
                ->with('error', 'Tide data not found.');
        }
        $request->validate([
            '_date' => 'required|string|max:255',
            '_time' => 'required|string|max:255',
            '_tide' => 'required|numeric',
            '_units' => 'required|string|max:255',
        ]);

        $measurement->update($request->all());

        return redirect()->route('tidegauges.view', ['id' => $measurement->tideGauge->id])
            ->with('success', 'Tide data updated successfully.');
    }

    public function destroy(String $id)
    {
        $measurement = Measurement::find($id);
        if (!$measurement) {
            return redirect()->route('measurement.index')
                ->with('error', 'Tide data not found.');
        }
        $tideGauge = $measurement->tideGauge;
        $measurement->delete();

        return redirect()->route('tidegauges.view', ['id' => $tideGauge->id])
            ->with('success', 'Tide data deleted successfully.');
    }
}
