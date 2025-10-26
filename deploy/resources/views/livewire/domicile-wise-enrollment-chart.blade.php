<div class="bg-white rounded-r-lg shadow flex items-center">
    <div
        wire:ignore
        x-data="{
            chart: null,
            createChart(payload) {
                const ctx = this.$refs.domicileChart.getContext('2d');

                // Destroy existing chart if it exists
                if (this.chart) {
                    this.chart.destroy();
                    this.chart = null;
                }

                const labels = payload.labels;
                const data = payload.data;
                const backgrounds = payload.backgrounds.slice(0, labels.length);
                const borders = payload.borders.slice(0, labels.length);

                this.chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Enrollments',
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
                            title: { display: true, text: 'Domicile-wise Enrollments' }
                        },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        }"
        x-init="
            // Initial render
            createChart(@js($domicileData));

            // Listen for Livewire updates
            Livewire.on('domicileChartUpdated', payload => {
                if (Array.isArray(payload)) payload = payload[0]; // unwrap array
                createChart(payload);
            });
        "
        class="w-[600px] h-[400px] p-3"
    >
        <canvas x-ref="domicileChart"></canvas>
    </div>
</div>
