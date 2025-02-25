<x-guest-layout css="style">
    <header>
        <h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link class="logout" :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    &lt;
                </x-dropdown-link>
            </form>
            散歩
        </h1>
    </header>
    <main>
        <div id="walk" class="container">
            <div id="map"></div>

            <div>
                <select id="distance" name="distance">
                    <option value="" selected disabled>時間を選択してください</option>
                    {{-- <option value="3">開発用</option> --}}
                    <option value="1">１０～１５分</option>
                    <option value="2">２０～３０分</option>
                    <option value="4">４０～６０分</option>
                </select>
                <div id="messages">
                    <p><span id="distance-result"></span>kmの経路ができました。<br>予想時間は<span id="time-result"></span>分です。</p>
                    <p>散歩中です。散歩が終わったら<br>「散歩完了」を押してください。</p>
                </div>
            </div>

            <div class="walk-btns">
                <button class="btn proceed-btn generate-route">経路を生成</button>

                <button class="btn generate-route">もう一度生成する</button>
                <button id="decide-route" class="btn proceed-btn">これでOK！！</button>

                <button id="start-btn" class="btn proceed-btn">散歩を始める</button>

                <button id="finish-btn" class="btn proceed-btn">散歩完了</button>
            </div>

            <div>
                <button id="stop-btn" class="btn hide">やめる</button>
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
                        <th id="title" colspan="5"></th>
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

            <dl>
                <div>
                    <dt>わんダムウォークとは？</dt>
                    <dd>
                        <p class="indent">わんダムウォークは飼い犬の認知症を予防するための散歩補助アプリです。毎日違う経路を散歩することで飼い犬の脳を刺激できます。いつもと違う経路を散歩しようと思っても考えるのが面倒だから結局同じ道に…なんてことはよくあること。このアプリはボタンを押すだけで経路を生成してくれます。また、散歩した日がカレンダーに記録されるので、塗り絵感覚で散歩を楽しむこともできます。</p>
                        <p class="indent">ちなみにアプリ名は、毎日異なるランダムな経路を散歩するという点から「ランダムウォーク」と考えましたが、ちょっと味気ないので犬のためのアプリであることに着目して「ラン」を泣き声の「わん」にして、「わんダムウォーク」となりました。</p>
                    </dd>
                </div>
                <div>
                    <dt>開発の経緯</dt>
                    <dd>
                        <p class="indent">我が家で昔飼っていた犬が晩年に認知症になってしまい、そのお世話が非常に大変だったという体験からこのアプリを開発しました。認知症になってしまった犬は昼夜問わず大きな声で鳴いたり、同じ場所をずっとぐるぐる回るように歩いたり、狭いところに入って出られなくなったりします。愛犬には最期まで健康でいてほしいはずなので、その一助になれば幸いです。</p>
                    </dd>
                </div>
                <div>
                    <dt>使い方</dt>
                    <dd>
                        <p>本アプリは以下の流れで使用します。</p>
                        <ul>
                            <li><br>1. 散歩時間を選択して経路を生成</li>
                            <li>2. 持ち物をチェック</li>
                            <li>3. 散歩スタート</li>
                            <li>4. 終わったらカレンダーに記録</li>
                        </ul>
                        <br>
                        <p class="indent">生成した経路には方向を示す矢印がついています。経路が重複して見にくい場合は、経由地点に立てられたマーカーを参考にしてください。マーカーにはアルファベットが振られており、B→C→D→…という順に進んでください。</p>
                        <p class="indent">スマートフォンのGPSをオンにしていないと使用できないことに注意してください。なお、散歩時間については10~15分を老犬、20~30分を小型犬、40~60分を大型犬と想定しています。散歩時間は不動産公正取引協議会連合会が定める「不動産の表示に関する公正競争規約施行規則」を参考に、徒歩を時速4.8kmとして計算しています。</p>
                    </dd>
                </div>
                <div>
                    <dt>利用上の注意</dt>
                    <dd>
                        <p class="indent">利用した散歩経路はデータベースに保存されませんが、「ユーザー名」、「持ち物」、「散歩をした年月日」は開発者が閲覧できるのでプライバシーにかかわる情報を入力しないでください。</p>
                        <p class="indent">歩きスマホをしないように注意してください。当アプリは散歩中に使用することを想定しているものですが、画面を確認する際は必ず周囲の状況を確認してください。</p>
                        <p class="indent">当アプリは、ユーザーの利便性向上を目的として提供されておりますが、利用中に発生した損害やトラブル、または第三者による不正アクセス、情報漏洩等のセキュリティ事故について、開発者は一切の責任を負いません。</p>
                    </dd>
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
                    <dd>あなたのユーザー名は {{ $userName }} です。</dd>
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
    {{-- <script>
        (g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })({
        key: "{{ $key }}",
        v: "weekly",
        // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
        // Add other bootstrap parameters as needed, using camel case.
        });
    </script> --}}
    <script src="{{asset('js/main.js') }}"></script>
</x-guest-layout>
