<div class="bg-white rounded-r-lg shadow flex items-center">
    <div class="w-[600px] h-[400px] p-3" wire:ignore>
        <canvas id="enrollmentAgeGroupChart"></canvas>
    </div>
</div>

@push('script')
<script>
    document.addEventListener('livewire:initialized', () => {
        const ctx = document.getElementById('enrollmentAgeGroupChart').getContext('2d');
        let ageGroupChart;

        // 1. Initialize chart
        ageGroupChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @js($initialLabels),
                datasets: [{
                    label: 'Total Enrollment',
                    data: @js($initialData),
                    backgroundColor: @js($initialBackgrounds),
                    borderColor: @js($initialBorders),
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // '' horizontal bars
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Enrollment by Age Group' }
                }
            }
        });

        // 2. Listen for Livewire updates
        // Livewire.on('chartDataUpdated', (event) => {
        //     console.log(event)
        //     ageGroupChart.data.labels = event.labels;
        //     ageGroupChart.data.datasets[0].data = event.data;
        //     ageGroupChart.data.datasets[0].backgroundColor = event.backgrounds;
        //     ageGroupChart.data.datasets[0].borderColor = event.borders;
        //     ageGroupChart.update();
        // });

            Livewire.on('chartDataUpdated', (event) => {
            const updated = event.data;
            ageGroupChart.data.labels = updated.labels;
            ageGroupChart.data.datasets[0].data = updated.data;
            ageGroupChart.data.datasets[0].backgroundColor = updated.backgroundColor;
            ageGroupChart.data.datasets[0].borderColor = updated.borderColor;
            ageGroupChart.update();
        });

        // 3. Cleanup
        Livewire.hook('element.removed', (el) => {
            if (el.id === 'enrollmentAgeGroupChart') {
                ageGroupChart.destroy();
            }
        });
    });
</script>
@endpush
