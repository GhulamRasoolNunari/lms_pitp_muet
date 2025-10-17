<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
    <!-- Metric Item Start -->
    <x-metric-card headingLabel="Registered Students" :count="$registeredtudentsCount" />
    <!-- Metric Item End -->

    <!-- Metric Item Start -->
    <x-metric-card headingLabel="Enrolled Students" :count="$enrolledstudentsCount" />
    <!-- Metric Item End -->

    <!-- Metric Item Start -->
    <x-metric-card headingLabel="Phases" :count="$phasesCount" />
    <!-- Metric Item End -->

    <!-- Metric Item Start -->
    <x-metric-card headingLabel="Campus" :count="$campusCount" />
    <!-- Metric Item End -->


</div>
