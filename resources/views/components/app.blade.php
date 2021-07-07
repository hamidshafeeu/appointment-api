<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Vaccine Appointments • HPA</title>
    <meta name="title" content="Vaccine Appointments • HPA">
    <meta name="description" content="Get yourself signed up for an online appointment. No more queues.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://book.hpa.gov.mv/">
    <meta property="og:title" content="Vaccine Appointments • HPA">
    <meta property="og:description" content="Get yourself signed up for an online appointment. No more queues.">
    <meta property="og:image" content="assets/images/dhifaau-logo-primary.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://book.hpa.gov.mv/">
    <meta property="twitter:title" content="Vaccine Appointments • HPA">
    <meta property="twitter:description" content="Get yourself signed up for an online appointment. No more queues.">
    <meta property="twitter:image" content="">
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="assets/images/dhifaau-logo-primary.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <style>
        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;  /* Preferred icon size */
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;

            /* Support for all WebKit browsers. */
            -webkit-font-smoothing: antialiased;
            /* Support for Safari and Chrome. */
            text-rendering: optimizeLegibility;

            /* Support for Firefox. */
            -moz-osx-font-smoothing: grayscale;

            /* Support for IE. */
            font-feature-settings: 'liga';
            }
    </style>
</head>

<body class="bg-gray-50">

    <x-nav></x-nav>



    
    <div class="relative py-0 md:py-16">


        <div class="hidden z-0 absolute inset-0 overflow-hidden rounded-3xl lg:block" aria-hidden="true">
            <svg class="absolute bottom-full left-full transform translate-y-1/3 -translate-x-2/3 xl:bottom-auto xl:top-0 xl:translate-y-0"
                width="404" height="384" fill="none" viewBox="0 0 404 384" aria-hidden="true">
                <defs>
                    <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20"
                        patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                            fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="384" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)" />
            </svg>


            <svg class="absolute top-full transform -translate-y-1/3 -translate-x-1/3 xl:-translate-y-1/2"
                width="404" height="384" fill="none" viewBox="0 0 404 384" aria-hidden="true">
                <defs>
                    <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20"
                        patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                            fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="384" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)" />
            </svg>
        </div>
        <div class=" max-w-7xl mx-auto bg-transparent lg:bg-transparent lg:px-8">
            <div class="relative max-w-md py-12 px-4 space-y-6 sm:max-w-3xl sm:py-16 sm:px-6 lg:max-w-none lg:p-0 lg:col-start-4 lg:col-span-6">

                <x-message></x-message>

                {{ $slot }}
            </div>    
        </div>
    </div>

    <x-footer></x-footer>

</body>

</html>
