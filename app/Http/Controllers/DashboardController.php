<?php

namespace App\Http\Controllers;

use App\Models\SmartMeter;
use App\Models\UsageRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the total number of SmartMeter records
        $totalSmartMeters = SmartMeter::count();

        // Get the total usage for today (sum of consumption for today's records)
        $totalUsageToday = UsageRecord::whereDate('recorded_at', now())->sum('consumption');

        // Get the number of inactive SmartMeter records
        $inactiveMeters = SmartMeter::where('status', 'inactive')->count();

        // Get the data for the chart (usage by date)
        $usageData = UsageRecord::selectRaw('DATE(recorded_at) as date, SUM(consumption) as total')
            ->groupBy('date')
            ->pluck('total')
            ->toArray();

        // Get the dates for the chart (grouped by date)
        $usageDates = UsageRecord::selectRaw('DATE(recorded_at) as date')
            ->groupBy('date')
            ->pluck('date')
            ->toArray();

        // Pass all variables to the view
        return view('dashboard', compact('totalSmartMeters', 'totalUsageToday', 'inactiveMeters', 'usageData', 'usageDates'));
    }
}
