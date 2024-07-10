<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <header>
        <h1>LOGO</h1>
        <h1>アプリ名</h1>
    </header>

    <main>
        <div id="walk" class="container">
            <div id="map"></div>

            <input type="text" id="lat" placeholder="Latitude">
            <input type="text" id="lon" placeholder="Longitude">
            <input type="text" id="per" placeholder="Perimeter (km)">
            <button id="start">Generate Route</button>
            <div id="result"></div>
            <h1>1</h1>
            <h1>2</h1>
            <h1>3</h1>
            <h1>4</h1>
            <h1>5</h1>
            <h1>6</h1>
            <h1>7</h1>
            <h1>8</h1>
            <h1>9</h1>
            <h1>10</h1>
        </div>

        <div id="calendar" class="container">
            <table>
                <thead>
                    <tr>
                        <th id="prev">&laquo;</th>
                        <th id="title" colspan="5">2020/05</th>
                        <th id="next">&raquo;</th>
                    </tr>
                    <tr>
                        <th>日</th>
                        <th>月</th>
                        <th>火</th>
                        <th>水</th>
                        <th>木</th>
                        <th>金</th>
                        <th>土</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- <tr>
                        <td class="disabled">1</td>
                        <td class="disabled">1</td>
                        <td class="disabled">1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1</td>
                        <td class="today">1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                    </tr> --}}
                </tbody>
                <tfoot>
                    <tr>
                        <td id="today" colspan="7">今月に戻る</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div id="belongings" class="container">
            <h1>持ち物リスト</h1>
        </div>
        <div id="config" class="container">
            <h1>設定</h1>
        </div>
    </main>

    <footer>
        <ul>
            <li>散歩</li>
            <li>カレンダー</li>
            <li>持ち物リスト編集</li>
            <li>設定</li>
        </ul>
    </footer>
    {{-- <script
        src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key={{ $key }}&callback=initMap"
        async defer>
    </script> --}}
    <script src="{{asset('js/main.js') }}"></script>
</body>
</html>
