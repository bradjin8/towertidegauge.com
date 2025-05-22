<?php

namespace App\Http\Controllers;

use App\Models\DeviceSettings;
use Illuminate\Support\Facades\DB;

class DeviceSettingsController extends Controller
{
    public function index()
    {
        $sub = DB::table('device_settings')
            ->select('serial', 'settings_json', 'created_at')
            ->selectRaw(
                'ROW_NUMBER() OVER (PARTITION BY serial ORDER BY id DESC) AS rn'
            );

        $settings = DB::query()              // or DB::table(DB::raw('(...) as t'))
        ->fromSub($sub, 't')   // gives the sub-query an alias
        ->where('rn', '<=', 5)->get()
            ->sortBy('serial');
//            ->sortByDesc('created_at');

        return view('device_settings.index', compact('settings'));
    }

    public function view(string $serial)
    {
        $settings = DeviceSettings::query()->where('serial', $serial)->first();
        if (!$settings) {
            $json = '{}';
        } else {
            $json = $settings->settings_json;
        }

        return view('device_settings.view', compact('serial', 'json'));
    }
}
