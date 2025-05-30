<?php

namespace App\Http\Controllers;

use App\Models\DeviceSettings;
use App\Models\Measurement;
use App\Models\TideGauge;
use Illuminate\Http\Request;

class TideGaugeController extends Controller
{
    public function index()
    {
        $tideGauges = [];
        if (auth()->user()->is_admin) {
            $tideGauges = TideGauge::all();
        } else {
            $tideGauges = auth()->user()->tideGauges;
        }
        return view('tidegauges.index', compact('tideGauges'));
    }

    public function create()
    {
        return view('tidegauges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            '_serial' => 'required|string|max:255',
            '_country' => 'required|string|max:255',
            '_loc' => 'required|string|max:255',
            '_lat' => 'required|numeric',
            '_lon' => 'required|numeric',
        ]);

        TideGauge::create($request->all());

        return redirect()->route('tidegauges.index')
            ->with('success', 'Tide Gauge added successfully.');
    }

    public function view(String $id)
    {
        $tideGauge = TideGauge::find($id);
        if (!$tideGauge) {
            return redirect()->route('tidegauges.index')
                ->with('error', 'Tide Gauge not found.');
        }
        $measurements = $tideGauge->measurements->sortByDesc('created_at')->take(50);

        return view('tidegauges.view', compact('tideGauge', 'measurements'));
    }

    public function edit(String $id)
    {
        $tideGauge = TideGauge::find($id);
        if (!$tideGauge) {
            return redirect()->route('tidegauges.index')
                ->with('error', 'Tide Gauge not found.');
        }

        return view('tidegauges.edit', compact('tideGauge'));
    }

    public function update(Request $request, String $id)
    {
        $tideGauge = TideGauge::find($id);
        if (!$tideGauge) {
            return redirect()->route('tidegauges.index')
                ->with('error', 'Tide Gauge not found.');
        }
        $request->validate([
            '_serial' => 'required|string|max:255',
            '_country' => 'required|string|max:255',
            '_loc' => 'required|string|max:255',
            '_lat' => 'required|numeric',
            '_lon' => 'required|numeric',
        ]);

        $tideGauge->update($request->all());

        return redirect()->route('tidegauges.index')
            ->with('success', 'Tide Gauge updated successfully.');
    }

    public function destroy(String $id)
    {
        $tideGauge = TideGauge::find($id);
        if (!$tideGauge) {
            return redirect()->route('tidegauges.index')
                ->with('error', 'Tide Gauge not found.');
        }
        $tideGauge->delete();

        return redirect()->route('tidegauges.index')
            ->with('success', 'Tide Gauge deleted successfully.');
    }
}
