<div class="bg-gray-300 rounded-lg shadow p-6">
    <h2 class="text-lg font-bold mb-4">Grafik Pemakaian Listrik</h2>
    <canvas id="usageChart"></canvas>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartData = @json($this->getChartData());
        const ctx = document.getElementById('usageChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.dates,
                datasets: [{
                    label: 'Pemakaian Listrik (kWh)',
                    data: chartData.consumptions,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });
    </script>
@endpush
