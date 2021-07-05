<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000000" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vaccine Appointments • HPA</title>
    <meta name="title" content="Vaccine Appointments • HPA">
    <meta name="description" content="Get yourself signed up for an online appointment.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://book.hpa.gov.mv/">
    <meta property="og:title" content="Vaccine Appointments • HPA">
    <meta property="og:description" content="Get yourself signed up for an online appointment.">
    <meta property="og:image" content="https://my.health.mv/dhifaau-logo-primary.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://book.hpa.gov.mv/">
    <meta property="twitter:title" content="Vaccine Appointments • HPA">
    <meta property="twitter:description" content="Get yourself signed up for an online appointment.">
    <meta property="twitter:image" content="https://my.health.mv/dhifaau-logo-primary.png">
    <base href="/" />
    <link rel="icon" type="image/x-icon" href="https://my.health.mv/dhifaau-logo-primary.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

   
    @if (isset($ngAssets) && count($ngAssets))
        <link rel="stylesheet" href="/build/{{ $ngAssets['styles'] }}">
    @endif
  </head>
  <body class="antialiased font-sans mat-typography">
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <app-root></app-root>
    @if (isset($ngAssets) && count($ngAssets))
        <script src="/build/{{ $ngAssets['runtime'] }}" defer></script>
        <script src="/build/{{ $ngAssets['polyfills'] }}" defer></script>
        <script src="/build/{{ $ngAssets['main'] }}" defer></script>
    @endif
  </body>
</html>