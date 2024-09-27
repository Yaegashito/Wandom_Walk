<x-guest-layout>
    <main>
        <div id="walk" class="container">
            <div id="map"></div>

            <div>
                <select id="distance" name="distance">
                    <option value="" selected disabled>時間を選択してください</option>
                    <option value="3">開発用</option>
                    <option value="1">１０～１５分</option>
                    <option value="2">２０～３０分</option>
                    <option value="4">４０～６０分</option>
                    {{-- 徒歩1分80m(=時速4.8km)と想定、根拠法令も --}}
                </select>
                <div id="messages">
                    <p><span id="distance-result"></span>kmの経路ができました。<br>予想時間は<span id="time-result">〇〇</span>分です。</p>
                    <p>散歩中です。散歩が終わったら<br>「散歩完了」を押してください。</p>
                </div>
            </div>

            <div class="walk-btns">
                <button class="walk-btn proceed-btn generate-route">経路を生成</button>

                <button class="walk-btn generate-route regenerate">もう一度生成する</button>
                <button id="decide-route" class="walk-btn proceed-btn right-btn">これでOK！！</button>

                <button id="start-btn" class="walk-btn proceed-btn">散歩を始める</button>

                <button id="finish-btn" class="walk-btn proceed-btn">散歩完了</button>
            </div>

            <div>
                <button id="stop-btn" class="walk-btn hide">やめる</button>
            </div>

            <div id="walk-belongings">
                <h2>持ち物リスト</h2>
                <ul>
                    @foreach ($belongings as $belonging)
                    <li>
                        {{ $belonging->belonging }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div id="calendar" class="container">
            <table>
                <thead>
                    <tr>
                        <th id="prev">前月</th>
                        <th id="title" colspan="5">2020/05</th>
                        <th id="next">翌月</th>
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
                <tbody class="tbody">
                    {{-- <tr>
                        <td class="disabled">1</td>
                        <td class="disabled">1</td>
                        <td class="disabled">1</td>
                        <td>1</td>
                        <td>1</td>
                        <td class="today">1</td>
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
                    {{ $belonging->belonging }}
                    <span
                        class="delete"
                        data-id="{{ $belonging->id }}">
                        削除
                    </span>
                </li>
                @endforeach
            </ul>
            <form>
                <input type="text" name="belonging">
                <button>追加</button>
            </form>

        </div>

        <div id="config" class="container">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('ログアウト') }}
                </x-dropdown-link>
            </form>

            <dl>
                <div>
                    <dt>わんダムウォークとは？</dt>
                    <dd>
                        <ul>
                            <li>アプリの概要</li>
                            <li>名前の由来</li>
                            <li>徒歩の時速</li>
                            <li>開発の経緯</li>
                        </ul>
                    </dd>
                </div>
                <div>
                    <dt>簡単な使い方</dt>
                    <dd>中身</dd>
                </div>
                <div>
                    <dt>ご意見送信フォーム</dt>
                    <dd>
                        <div id="opinion-submit">
                            <p>良かったところ、使いにくいところなどなど、ご意見お待ちしております！</p>
                            <textarea id="opinion"></textarea>
                            <button id="opinion-btn">送信</button>
                        </div>
                        <p id="thanks">ご意見ありがとうございました！！</p>
                    </dd>
                </div>
                <div>
                    <dt>あなたのプロフィール</dt>
                    <dd>{{ $userName }}</dd>
                </div>
                <div>
                    <dt>パスワード変更</dt>
                    <dd>
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </dd>
                </div>
                <div>
                    <dt>アカウント削除</dt>
                    <dd>
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
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
            <li>その他</li>
        </ul>
    </footer>
    <script>
        (g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })({
        // key: "{{ $key }}",
        v: "weekly",
        // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
        // Add other bootstrap parameters as needed, using camel case.
        });
    </script>
    <script src="{{asset('js/main.js') }}"></script>
</x-guest-layout>
