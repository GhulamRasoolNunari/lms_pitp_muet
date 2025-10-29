<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Site keywords here">
    <meta name="description" content="#">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Site Title -->
    <title>PITP</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet">

    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('form_assets') }}/img/formify-favicon.html">

    <!-- Formify CSS Stylesheet -->
    <link rel="stylesheet" href="{{ asset('form_assets') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('form_assets') }}/css/font-awesome-all.min.css">
    <link rel="stylesheet" href="{{ asset('form_assets') }}/css/jquery.classycountdown.min.css">
    <link rel="stylesheet" href="{{ asset('form_assets') }}/css/nice-select.min.css">
    <link rel="stylesheet" href="{{ asset('form_assets') }}/css/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('form_assets') }}/css/reset.css">
    <link rel="stylesheet" href="{{ asset('form_assets') }}/css/style.css">
</head>

<body>
    <section class="formify-form formify-form__bookingv2">
        <div class="container container__bookingv2">
            <div class="row">
                <div class="col-12">
                    <!-- Form Area -->

                    <div class="formify-form__bookingv2-header">
                        <img src="{{ asset('form_assets') }}/image/ai.JPG" alt=""
                            style="height:270px ;object-fit: cover;width:100%;">
                    </div>
                    <div class="row">
                        {{ $slot }}

                    </div>
                </div>

                <!-- End Form Area -->
            </div>
        </div>
        </div>
        </div>


        </div>

        </div>
        </div>
        </div>
        </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Formify Scripts -->
    <script src="{{ asset('form_assets') }}/js/jquery.min.js"></script>
    <script src="{{ asset('form_assets') }}/js/jquery-migrate.js"></script>
    <script src="{{ asset('form_assets') }}/js/bootstrap.min.js"></script>

    <script src="{{ asset('form_assets') }}/js/final-countdown.min.js"></script>

    {{-- <script src="{{ asset('form_assets') }}/js/nice-select.min.js"></script> --}}
    <script src="{{ asset('form_assets') }}/js/flatpickr.js"></script>
    <script src="{{ asset('form_assets') }}/js/main.js"></script>


    <script>
        $(document).ready(function() {
            const form = $("#multiStepForm");
            const steps = form.find(".tab-pane");
            const links = $(".formify-form__nav a");
            const progress = $(".progress-bar");
            const completionPercent = $(
                ".formify-form__quiz-banner-progress--percent"
            );

            let currentStep = 0;

            function showStep(stepIndex) {
                steps.removeClass("show active");
                $(steps[stepIndex]).addClass("show active");

                // Update classes on navigation links
                links.removeClass("active active-done");
                links.each(function(index) {
                    if (index < stepIndex) {
                        $(this).addClass("active-done");
                    } else if (index === stepIndex) {
                        $(this).addClass("active");
                    }
                });

                updateProgress();
                $(".formify-form__quiz-current").addClass("zoom-out");
                setTimeout(function() {
                    $(".formify-form__quiz-current")
                        .text(stepIndex + 1)
                        .removeClass("zoom-out")
                        .addClass("zoom-in");
                }, 300);
                updateCompletionPercent();
            }

            function updateProgress() {
                const percent = (currentStep / (steps.length - 1)) * 100;
                progress.css("width", percent + "%");
            }

            function updateCompletionPercent() {
                const percent = ((currentStep + 1) / steps.length) * 100;
                completionPercent.text(`${percent.toFixed(0)}% Complete`);
            }

            $(".next-step").click(function(event) {
                event.preventDefault();
                currentStep++;
                if (currentStep < steps.length) {
                    showStep(currentStep);
                } else {
                    // Handle form submission or completion here
                }
            });

            $(".prev-step").click(function(event) {
                event.preventDefault();
                currentStep--;
                if (currentStep >= 0) {
                    showStep(currentStep);
                }
            });

            links.click(function(event) {
                event.preventDefault();
                const clickedStep = links.index(this);
                if (clickedStep >= 0 && clickedStep < steps.length) {
                    currentStep = clickedStep;
                    showStep(currentStep);
                }
            });

            showStep(currentStep);
        });
        window.addEventListener('student-saved', event => {
            let data = event.detail;
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            })
            Toast.fire({
                icon: "success",
                title: data.text
            });

        });
    </script>

    <script>
        // Initialize flatpickr on the div element
        // flatpickr("#calendar", {
        //     inline: true, // Display the calendar inline in the div
        //     dateFormat: "Y-m-d", // Date format YYYY-MM-DD
        //     onChange: function(selectedDates, dateStr, instance) {
        //         // When a date is selected, show it in the input field
        //         document.getElementById("dateInput").value = dateStr;
        //     },
        // });
    </script>
</body>

</html>
