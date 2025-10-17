<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sign In | PITP-MUET Portal</title>
    <link rel="icon" href="{{ asset('assets/logo/fav_icon.png') }}" type="image/png" />
    <style>
        form .checkbox {
            /*accent-color: #f26822;*/
            accent-color: #005a9e;
        }

        form .checkbox a {
            margin-left: auto;
            font-size: 14px;
            text-decoration: none;
            color: black;
        }

        form a:hover {
            color: #000;
        }

        .gradient-button-muet {
            background: linear-gradient(-45deg, #A7D8BB, #145E80, #043D56);
            background-size: 400% 400%;
            animation: gradientMute 8s ease infinite;

        }

        .gradient-button {
            background: linear-gradient(-45deg, #fb460b, #f05826, #ff813f);
            background-size: 400% 400%;
            animation: gradientAnim 8s ease infinite;
        }

        @keyframes gradientAnim,
        gradientMute {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>

<body class="flex items-center justify-center bg-gray-100" x-data="{ page: 'comingSoon', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark bg-gray-900': darkMode === true }">

    <!-- ===== Preloader Start ===== -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {},
            },
            safelist: [
                'bg-red-500', 'text-green-600'
            ]
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    @include('partials.preloader')
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->

    </head>

    <body class="">
        <div class="flex flex-col lg:flex-row w-full h-full lg:h-[100vh] shadow-lg bg-white rounded-lg overflow-hidden">

            <!-- Left SVG Section -->
            <div class="hidden lg:block lg:w-6/12 bg-center"
                style="display:flex; flex-direction:column; justify-content:center; align-items:center">
                <img src=" {{ asset('assets/logo/pitp-ii-muet.png') }}" style="width:100%; max-width:450px;">
                <div class="w-full lg:w-8/12 items-center justify-center px-8" style="max-width:500px">
                    <h2 class="text-4xl text-center font-semibold py-6">Instructions</h2>
                    <ol type="list-decimal" style="list-style:auto">
                        <li>Before logging in, ensure you have approved email ID and password.
                            <p> <i>Note: Make sure to change your password after login.</i></p>
                        </li>
                        <li>For any login issues or queries, email to:
                            <a class="text-blue-800" href="mailto:lms.assistant@admin.muet.edu.pk">lms.assistant@admin.muet.edu.pk</a>
                            <br>
                            Note: <em class="text-blue-800">Please include your CNIC number and full name when contacting for support.
</em>
                        </li>
                    </ol>
                </div>
                <!--<img src=" {{ asset('assets/logo/courses.png') }}"-->
                <!--    style="width:100%; max-width:700px; padding: 0px 15px 20px;">-->
                <!-- Background image only -->
            </div>

            <!-- Right Form Section -->
            <div class="w-full lg:w-6/12 flex items-center justify-center p-8 gradient-button-muet">
                <div class="w-full max-w-lg">
                    <div class="mb-8">
                        <!--<img src="{{ asset('assets/logo/muet-logo-dark.svg') }}" alt="Logo"-->
                        <!--    class="mx-auto max-w-xs mb-6" />-->
                        <h2 class="text-4xl text-white font-bold">Sign In</h2>
                        <p class="text-sm text-gray-100">Enter your email and password to sign in!</p>
                    </div>

                    <form class="space-y-4" method="POST" action="{{ route('login.attempt') }}">
                        @csrf
                        <div>
                            <label for="email" class="block text-m font-medium text-white mb-1">Email</label>
                            <input type="email" id="email" name="email" required placeholder="info@gmail.com"
                                class="w-full bg-white px-4 py-4 border-none rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                            @error('email')
                                <p class="text-white ms-2 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @php
                            $inputId = 'passwordInput_' . uniqid();
                        @endphp

                        <div x-data="{ show: false }">
                            <label for="password" class="block text-m font-medium text-white mb-1">Password</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" id="{{ $inputId }}" name="password"
                                    required placeholder="************"
                                    class="w-full bg-white px-4 py-4 border-none rounded-md pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-3 flex items-center text-gray-500 focus:outline-none">
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.964 9.964 0 012.393-4.419m2.08-1.782A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-1.307 2.572M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>

                            @error('password')
                                <p class="text-white ms-2 mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <button type="submit"
                            class="w-full bg-white text-gray-700 py-2 px-4 rounded-full text-lg font-semibold shadow-md hover:bg-gray-100 transition flex items-center justify-center gap-2 border border-gray-300">

                            Sign In
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12H3m0 0l4-4m-4 4l4 4m13-9v10a2 2 0 01-2 2h-5" />
                            </svg>
                        </button>

                        <a type="button" href="{{ route('student_registerd') }}"
                            class="w-full bg-white text-gray-700 py-2 px-4 rounded-full text-lg font-semibold shadow-md hover:bg-gray-100 transition flex items-center justify-center gap-2 border border-gray-300">

                            Register Now
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" stroke="currentColor"
                                    stroke-width="2" />
                            </svg>
                        </a>

                    </form>
                </div>
            </div>
        </div>
        {{-- </body> --}}
        <!-- ===== Page Wrapper End ===== -->
    </body>

</html>
