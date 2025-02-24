<x-guest-layout css="start">
<h1>スタート画面です</h1>
<main class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="consent transparent">
        <p>ページ下部の「利用上の注意」を<br>理解し、同意する</p>
        <input id="checkbox" type="checkbox">
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" style="width: 95%; margin-top: 48px;">

        <ul class="tabs">
            <li><a href="#" class="active" data-id="login">ログイン</a></li>
            <li><a href="#" data-id="register">新規登録</a></li>
        </ul>

        <section class="content active" id="login">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="username" />
                    {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    {{-- @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif --}}

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </section>

        <section class="content" id="register">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name2" :value="__('Name')" />
                    <x-text-input id="name2" disabled class="consented block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    {{-- <x-input-error :messages="$errors->get('name')" class="mt-2" /> --}}
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password2" :value="__('Password')" />

                    <x-text-input id="password2" disabled class="consented block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" disabled class="consented block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </section>
    </div>
    <div class="introduction" data-aos="fade-left" data-aos-anchor-placement="top-center">
        <h1>わんダムウォークとは？</h1>
        <p class="indent">わんダムウォークは飼い犬の認知症を予防するための散歩補助アプリです。毎日違う経路を散歩することで飼い犬の脳を刺激できます。いつもと違う経路を散歩しようと思っても考えるのが面倒だから結局同じ道に…なんてことはよくあること。このアプリはボタンを押すだけで経路を生成してくれます。また、散歩した日がカレンダーに記録されるので、塗り絵感覚で散歩を楽しむこともできます。</p>
        <p class="indent">ちなみにアプリ名は、毎日異なるランダムな経路を散歩するという点から「ランダムウォーク」と考えましたが、ちょっと味気ないので犬のためのアプリであることに着目して「ラン」を泣き声の「わん」にして、「わんダムウォーク」となりました。</p>
    </div>
    <div class="introduction" data-aos="fade-right" data-aos-offset="200">
        <h1>開発の経緯</h1>
        <p class="indent">昔飼っていた犬が晩年に認知症になってしまい、そのお世話が非常に大変だったという体験からこのアプリを開発しました。認知症になってしまった犬は昼夜問わず大きな声で鳴いたり、同じ場所をずっとぐるぐる回るように歩いたり、狭いところに入って出られなくなったりします。愛犬には最期まで健康でいてほしいはずなので、その一助になれば幸いです。</p>
    </div>
    <div class="introduction" data-aos="fade-left" data-aos-offset="200">
        <h1>利用上の注意</h1>
        <p class="indent">利用した散歩経路はデータベースに保存されませんが、「ユーザー名」、「持ち物」、「散歩をした年月日」は開発者が閲覧できるのでプライバシーにかかわる情報を入力しないでください。</p>
        <p class="indent">歩きスマホをしないように注意してください。当アプリは散歩中に使用することを想定しているものですが、画面を確認する際は必ず周囲の状況を確認してください。</p>
        <p class="indent">当アプリは、ユーザーの利便性向上を目的として提供されておりますが、利用中に発生した損害やトラブル、または第三者による不正アクセス、情報漏洩等のセキュリティ事故について、開発者は一切の責任を負いません。</p>
    </div>
    <a href="#top" class="logout btn page-top" data-aos="fade-right" data-aos-offset="10">はじめる</a>
</main>
<script src="{{asset('js/login.js') }}"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
AOS.init();
</script>
</x-guest-layout>
