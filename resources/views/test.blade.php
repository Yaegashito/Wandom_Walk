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
        <img src="" alt="">
        <h1>LOGO アプリ名</h1>
    </header>

    <main>
        <div id="walk" class="container">
            <div id="map"></div>

            <form id="route-form">
                <label for="distance">距離 (km):
                    <input type="number" id="distance" name="distance" step="0.1" required>
                </label>
                <button type="submit">経路を生成</button>
            </form>

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
            <ul>
                @foreach ($belongings as $belonging)
                <li>
                    {{ $belonging }}
                    <span class="delete">×</span>
                </li>
                @endforeach
            </ul>
            <form action="">
                @csrf
                <input type="text">
                <button>追加</button>
            </form>

        </div>

        <div id="config" class="container">
            <h2>設定</h2>
            <dl>
                <div>
                    <dt>設定1</dt>
                    <dd>中身</dd>
                </div>
                <div>
                    <dt>設定2</dt>
                    <dd>中身</dd>
                </div>
                <div>
                    <dt>設定3</dt>
                    <dd>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('ログアウト') }}
                            </x-dropdown-link>
                        </form>
                    </dd>
                </div>
            </dl>
        </div>
    </main>

    <footer>
        <ul>
            <li>散歩</li>
            <li>カレンダー</li>
            <li>持ち物リスト</li>
            <li>設定</li>
        </ul>
    </footer>
      <script>
        (g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })({
        key: "{{ $key }}",
        v: "weekly",
        // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
        // Add other bootstrap parameters as needed, using camel case.
        });
    </script>
    <script src="{{asset('js/main.js') }}"></script>
</body>
</html>
