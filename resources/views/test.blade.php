<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="map"></div>

    <input type="text" id="lat" placeholder="Latitude">
    <input type="text" id="lon" placeholder="Longitude">
    <input type="text" id="per" placeholder="Perimeter (km)">
    <button id="start">Generate Route</button>
    <div id="result"></div>

    <script
        src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key={{ $key }}&callback=initMap"
        async defer></script>
    <script src="{{asset('js/main.js') }}"></script>
</body>
</html>
