<div class="bg-white shadow flex items-center rounded-l-lg">
    <div
        wire:ignore
        x-data="{
            chart: null,
            createChart(payload) {
                const ctx = this.$refs.enrollmentChart.getContext('2d');

                if (this.chart) {
                    this.chart.destroy();
                    this.chart = null;
                }

                const labels = payload.labels || [];
                const data = payload.data || [];

                const defaultBackgrounds = ['#27A486', '#41B87D', '#9ED96B', '#FFB347', '#F87171'];
                const defaultBorders = ['#1F7861', '#30B58B', '#77AA53', '#FF8C00', '#E11D48'];

                const backgroundColors = (payload.backgroundColor || defaultBackgrounds).slice(0, data.length);
                const borderColors = (payload.borderColor || defaultBorders).slice(0, data.length);

                this.chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Enrollment',
                            data: data,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Education Group (Enrolled Students)'
                            }
                        }
                    }
                });
            }
        }"
        x-init="
            // Initial render
            createChart(@js($educationGroupData));

            // Livewire update
            Livewire.on('educationChartUpdated', payload => {
                console.log('🔁 Updating Education Chart', payload);

                // Unwrap array if Livewire sends it like that
                if (Array.isArray(payload) && payload.length > 0) {
                    payload = payload[0];
                }

                createChart(payload);
            });
        "
        class="w-[400px] h-[400px] p-3"
    >
        <canvas x-ref="enrollmentChart"></canvas>
    </div>
</div>
