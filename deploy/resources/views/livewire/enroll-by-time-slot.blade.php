<div class="p-2 bg-white rounded-lg shadow">
    <div
        wire:ignore
        x-data="{
            chart: null,
            createChart(payload) {
                const ctx = this.$refs.timeSlotChart.getContext('2d');

                // If chart exists → destroy before creating new
                if (this.chart) {
                    this.chart.destroy();
                    this.chart = null;
                }

                const { labels, morning, afternoon, earlyEvening, lateEvening, weekend, colors } = payload;

                this.chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            { label: 'Morning (9 AM to 12 PM)', data: morning, backgroundColor: colors.morning },
                            { label: 'Afternoon (12 PM to 3 PM)', data: afternoon, backgroundColor: colors.afternoon },
                            { label: 'Early Evening (3 PM to 6 PM)', data: earlyEvening, backgroundColor: colors.earlyEvening },
                            { label: 'Late Evening (6 PM to 9 PM)', data: lateEvening, backgroundColor: colors.lateEvening },
                            { label: 'Weekend (Sat & Sun)', data: weekend, backgroundColor: colors.weekend },
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { stacked: true, grid: { display: false } },
                            y: { stacked: true, beginAtZero: true }
                        },
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'Enrollment by Time Slot' },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => {
                                        const label = ctx.dataset.label || '';
                                        const value = ctx.parsed.y ?? ctx.parsed ?? 0;
                                        return `${label}: ${value}`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }"
        x-init="
            // Initial chart render
            createChart({
                labels: @js($timeSlotData['labels'] ?? []),
                morning: @js($morning ?? []),
                afternoon: @js($afternoon ?? []),
                earlyEvening: @js($earlyEvening ?? []),
                lateEvening: @js($lateEvening ?? []),
                weekend: @js($weekend ?? []),
                colors: @js($colors ?? [])
            });

            // Listen for Livewire update event
            Livewire.on('timeSlotChartUpdated', payload => {
                console.log('🔁 Updating Chart', payload);
                createChart(payload);
            });
        "
        class="w-[1000px] h-[400px]"
    >
        <canvas x-ref="timeSlotChart"></canvas>
    </div>
</div>
