<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\TideGauge;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     */
    public function index(Request $request): View
    {
        $data = [];
        if (auth()->user()->is_admin) {
            $user_count = User::all()->count();
            $tide_gauge_count = TideGauge::all()->count();
            $data = [
                'users' => $user_count,
                'tideGauges' => $tide_gauge_count,
            ];
        } else {
            $tide_gauge_count = auth()->user()->tideGauges->count();
            $data = [
                'tideGauges' => $tide_gauge_count,
            ];
        }
        return view('dashboard', [
            'data' => $data,
        ]);
    }
}
