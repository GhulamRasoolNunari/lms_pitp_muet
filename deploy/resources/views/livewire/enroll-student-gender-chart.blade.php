<div class="p-6 bg-white rounded-l-lg shadow w-[400px] h-[500px]" wire:ignore>
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Enrollment by Gender</h3>
<div class="w-[300px] h-[400px]">
    <canvas id="enrollmentGenderChart"></canvas>
</div>
</div>

@push('script')
<script>
    document.addEventListener('livewire:initialized', () => {

        const ctx = document.getElementById('enrollmentGenderChart').getContext('2d');
        let genderChart;

        // 1. Initialize the chart instance
        genderChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @js($initialLabels),
                datasets: [{
                    label: 'Enrollment by Gender',
                    data: @js($initialData),
                    backgroundColor: @js($initialBackgrounds),
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Enrollment by Gender' }
                }
            }
        });


        // 2. Listen for Livewire event to update the chart (No change needed here)
        Livewire.on('chartDataUpdated', (event) => {
            console.log(event);
            const data = event.data;
            const labels = event.labels;
            const backgrounds = event.backgrounds;

            genderChart.data.labels = labels;
            genderChart.data.datasets[0].data = data;
            genderChart.data.datasets[0].backgroundColor = backgrounds;

            genderChart.update();
        });

        // 3. Cleanup
        Livewire.hook('element.removed', (el) => {
            if (el.id === 'enrollmentGenderChart') {
                genderChart.destroy();
            }
        });
    });
</script>
@endpush
