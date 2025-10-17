<div class="bg-white rounded-l-lg shadow flex items-center">
    <div
        wire:ignore
        x-data="{
            chart: null,
            createChart(payload) {
                const ctx = this.$refs.centerChart.getContext('2d');

                if (this.chart) {
                    this.chart.destroy();
                    this.chart = null;
                }

                const labels = payload.labels;
                const data = payload.data;
                const backgrounds = payload.backgroundColor.slice(0, labels.length);
                const borders = payload.borderColor.slice(0, labels.length);

                this.chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Enrollment',
                            data: data,
                            backgroundColor: backgrounds,
                            borderColor: borders,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Preferred Study Center (Enrolled Students)'
                            }
                        },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        }"
        x-init="
            // Initial render
            createChart(@js($centerGroupData ?? ['labels'=>[], 'data'=>[], 'backgroundColor'=>[], 'borderColor'=>[]]));

            // Listen for Livewire updates
            Livewire.on('centerChartUpdated', payload => {
                while (Array.isArray(payload)) payload = payload[0]; // unwrap all nested arrays
                createChart(payload);
            });
        "
        class="w-[400px] h-[400px] p-3"
    >
        <canvas x-ref="centerChart"></canvas>
    </div>
</div>
