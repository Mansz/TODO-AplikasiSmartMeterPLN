<x-filament::page>
    <!-- Statistik Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Statistik -->
        <div class="bg-black shadow rounded-lg p-6">
            <h2 class="text-lg font-bold">Total Smart Meter</h2>
            <p class="text-3xl mt-4">{{ \App\Models\SmartMeter::count() }}</p>
        </div>

        <div class="bg-black shadow rounded-lg p-6">
            <h2 class="text-lg font-bold">Total Penggunaan Hari Ini</h2>
            <p class="text-3xl mt-4">
                {{ \App\Models\UsageRecord::whereDate('recorded_at', now())->sum('consumption') }} kWh
            </p>
        </div>

        <div class="bg-black shadow rounded-lg p-6">
            <h2 class="text-lg font-bold">Smart Meter Tidak Aktif</h2>
            <p class="text-3xl mt-4">
                {{ \App\Models\SmartMeter::where('status', 'inactive')->count() }}
            </p>
        </div>
    </div>

    

    <!-- Grafik Statistik -->
    <div class="mt-8 bg-black shadow rounded-lg p-6">
        <h2 class="text-lg font-bold mb-4">Grafik Pemakaian Listrik</h2>
        <canvas id="usageChart"></canvas>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const usageData = @json($usageData); // Data konsumsi listrik
        const usageDates = @json($usageDates); // Data tanggal

        const ctx = document.getElementById('usageChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: usageDates,
                datasets: [{
                    label: 'Pemakaian Listrik (kWh)',
                    data: usageData,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });
    </script>
@endpush

</x-filament::page>
