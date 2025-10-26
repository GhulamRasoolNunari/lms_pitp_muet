<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
        MUET Portal
    </title>
    <link rel="icon" href="{{ asset('https://www.muet.edu.pk/sites/default/files/favicon.ico') }}" type="image/png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    {{-- <script src="h+ttps://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script> --}}
    {{-- <script src="
    https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js
    "></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @stack('styles')
    <style>
        .swal2-container {
            z-index: 100000000 !important;
        }
    </style>
</head>

@vite(['resources/css/app.css', 'resources/js/app.js'])
{{-- when its completed properly will remove tailwind cdn and js as well --}}
<script>
    tailwind.config = {
        theme: {
            extend: {},
        },
        safelist: [
            // Add any dynamic class names here to prevent purge removal
            'bg-red-500', 'text-green-600'
        ]
    }
</script>

<body x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }">
    <!-- ===== Preloader Start ===== -->
    @include('partials.preloader')


    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
{{-- doing just for now to avoid sidebar conflict --}}
     @includeFirst(['partials.sidebar.local', 'partials.sidebar'])

        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">

            <!-- Small Device Overlay Start -->
            @include('partials.overlay')
            <!-- Small Device Overlay End -->
            <!-- ===== Header Start ===== -->
            @include('partials.header')
            <!-- ===== Header End ===== -->
            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    {{-- <div class="grid grid-cols-12 gap-4 md:gap-6"> --}}
                    {{ $slot }}
                    {{-- </div> --}}
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->


    </div>
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.14.9/dist/cdn.min.js"></script> --}}
    @livewireScripts

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('countTo', (target, opts = {}) => {
                const cfg = Object.assign({
                    duration: 1200,
                    decimals: 0,
                    formatter: v => v.toLocaleString()
                }, opts);
                return {
                    from: 0,
                    to: Number(target || 0),
                    now: 0,
                    startTime: null,
                    display: '0',
                    observing: false,
                    start() {
                        const animate = (t) => {
                            if (!this.startTime) this.startTime = t;
                            const p = Math.min((t - this.startTime) / cfg.duration, 1);
                            const eased = 1 - Math.pow(1 - p, 3);
                            this.now = this.from + (this.to - this.from) * eased;
                            const fixed = this.now.toFixed(cfg.decimals);
                            this.display = cfg.formatter(cfg.decimals ? Number(fixed) : Math.round(this
                                .now));
                            if (p < 1) requestAnimationFrame(animate);
                        };
                        requestAnimationFrame(animate);
                    },
                    observeOnce(el) {
                        if (this.observing) return;
                        this.observing = true;
                        const io = new IntersectionObserver((entries) => {
                            if (entries.some(e => e.isIntersecting)) {
                                this.start();
                                io.disconnect();
                            }
                        }, {
                            threshold: 0.2
                        });
                        io.observe(el);
                    },
                    update(newVal) {
                        this.from = this.now || 0;
                        this.to = Number(newVal || 0);
                        this.startTime = null;
                        this.start();
                    }
                }
            });
        });
        Livewire.on('custom', (data) => {
            // For example with SweetAlert:
            Swal.fire({
                icon: data.icon || 'success',
                text: data.text || '',
                timer: 2000,
                showConfirmButton: false
            });

        });
        (function() {
            if (window.__toastBound) return;
            window.__toastBound = true;

            const bind = () => {
                Livewire.on('toast', ({
                    icon = 'success',
                    title = '',
                    text = ''
                } = {}) => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (t) => {
                            t.onmouseenter = Swal.stopTimer;
                            t.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon,
                        title,
                        text
                    });
                });
            };

            document.addEventListener('livewire:initialized', bind);
            document.addEventListener('livewire:navigated', () => {
                /* keep single binding */
            });
        })();
    </script>

    @stack('script')
    <!-- ===== Page Wrapper End ===== -->

</body>

</html>
