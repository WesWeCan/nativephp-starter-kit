<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    {{-- Viewport Options:
         - Basic: width=device-width, initial-scale=1
         - Disable Zoom: width=device-width, initial-scale=1, user-scalable=no
         - Edge-to-Edge: width=device-width, initial-scale=1, user-scalable=no, viewport-fit=cover
    --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, viewport-fit=cover">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=crimson-pro:200,200i,500,500i|inter-tight:100,100i,300,300i,500,500i"
        rel="stylesheet" />

    <!-- Scripts -->

    @routes
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

{{-- The native php safe area class is used to ensure the content is not covered by the notches of the device --}}
<body class="font-sans antialiased nativephp-safe-area">
    @inertia
</body>

</html>
