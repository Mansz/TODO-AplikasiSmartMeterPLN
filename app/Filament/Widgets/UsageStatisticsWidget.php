<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\UsageRecord;

class UsageStatisticsWidget extends Widget
{
    protected static ?string $heading = 'Laporan Pemakaian Listrik';
    protected static string $view = 'filament.widgets.usage-statistics-widget';

    public function getChartData(): array
    {
        $dates = UsageRecord::selectRaw('DATE(recorded_at) as date')
            ->groupBy('date')
            ->pluck('date')
            ->toArray();

        $consumptions = UsageRecord::selectRaw('DATE(recorded_at) as date, SUM(consumption) as total')
            ->groupBy('date')
            ->pluck('total')
            ->toArray();

        return [
            'dates' => $dates,
            'consumptions' => $consumptions,
        ];
    }
}
