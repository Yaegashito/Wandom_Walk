<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('img/favicon2.png') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('css/' . $attributes->get('css') . '.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    </head>
    <body>
        <div class="whole-container">
                {{ $slot }}
        </div>
    </body>
</html>
