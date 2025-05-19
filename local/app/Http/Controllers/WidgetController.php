<?php

namespace App\Http\Controllers;

use App\Models\TideGauge;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function show($serial) {
        $tide = TideGauge::query()->where('_serial', $serial)->first();
        if (!$tide) {
            return redirect('/');
        }
        $recent = $tide->measurements()->orderBy('created_at', 'desc')->first();

        return view('widget.show', compact('tide', 'recent'));
    }
}
