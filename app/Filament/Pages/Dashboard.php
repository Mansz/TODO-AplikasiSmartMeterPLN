<?php

namespace App\Filament\Pages;

use App\Models\SmartMeter;
use App\Models\UsageRecord;
use Filament\Pages\Page;
use App\Filament\Widgets\UsageStatisticsWidget;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home'; // Icon pada navigasi
    protected static string $view = 'filament.pages.dashboard'; // View Blade yang digunakan

    protected static ?string $navigationLabel = 'Dashboard'; // Label di navigasi
    protected static ?string $slug = 'dashboard'; // URL untuk halaman dashboard

    public $totalSmartMeters;
    public $totalUsageToday;
    public $inactiveMeters;
    public $usageData;
    public $usageDates;

    public function mount(): void
    {
        // Ambil data yang diperlukan sebelum halaman dimuat
        $this->totalSmartMeters = SmartMeter::count();
        $this->totalUsageToday = UsageRecord::whereDate('recorded_at', now())->sum('consumption');
        $this->inactiveMeters = SmartMeter::where('status', 'inactive')->count();

        // Ambil data untuk grafik
        $this->usageData = UsageRecord::selectRaw('DATE(recorded_at) as date, SUM(consumption) as total')
            ->groupBy('date')
            ->pluck('total')
            ->toArray();

        $this->usageDates = UsageRecord::selectRaw('DATE(recorded_at) as date')
            ->groupBy('date')
            ->pluck('date')
            ->toArray();
    }
    protected function getWidgets(): array
    {
        return [
            UsageStatisticsWidget::class,
        ];
    }
}
