<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    {{-- <body class="font-sans text-gray-900 antialiased"> --}}
    <body>
        <div class="whole-container">
        <header>
            <img src="{{ asset('img/favicon.png') }}" alt="ロゴ画像" width="42" height="42" class="favicon">
            <h1> わんダムウォーク</h1>
        </header>

            {{-- <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div> --}}

                {{ $slot }}
        </div>
    </body>
</html>
