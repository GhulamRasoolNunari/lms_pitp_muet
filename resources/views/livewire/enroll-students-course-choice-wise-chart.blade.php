<div class="bg-white rounded-r-lg shadow flex items-center">
    <div
        wire:ignore
        x-data="{
            chart: null,

            createChart(payload) {
                const ctx = this.$refs.courseChoiceChart.getContext('2d');

                if (this.chart) {
                    this.chart.destroy();
                    this.chart = null;
                }

                const labels = payload.labels;
                const data = payload.data;

                this.chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Enrolled Students',
                            data: data,
                            backgroundColor: '#42A5F5',
                            borderColor: '#1E88E5',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { x: { beginAtZero: true } },
                        plugins: {
                            legend: { display: false },
                            title: { display: true, text: 'Enrolled Students by Course Choice' }
                        }
                    }
                });
            }
        }"
        x-init="(() => {
            // Initial render
            let initialPayload = @js($courseChoiceData ?? []);
            if (Array.isArray(initialPayload)) initialPayload = initialPayload[0] ?? { labels: [], data: [] };
            createChart(initialPayload);

            // Listen for Livewire updates
            Livewire.on('courseChoiceChartUpdated', payload => {
                if (Array.isArray(payload)) payload = payload[0];
                createChart(payload);
            });
        })()"
        class="w-[1000px] h-[400px] p-4"
    >
        <canvas x-ref="courseChoiceChart"></canvas>
    </div>
</div>
