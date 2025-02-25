<x-guest-layout css="start">
    <div class="container">
        <h1>わんダムウォーク</h1>
        <p></p>
        {{-- <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"> --}}

            <!-- Session Status -->
            <x-auth-session-status :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Name -->
                <div class="input-group">
                    <x-input-label class="label" for="name" :value="__('Name')" />
                    <x-text-input class="form box-size" id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="username" />
                    {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                    <x-input-error :messages="$errors->get('name')" />

                </div>

                <!-- Password -->
                <div class="input-group">
                    <x-input-label class="label" for="password" :value="__('Password')" />

                    <x-text-input class="form box-size" id="password"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Remember Me -->
                {{-- <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div> --}}

                <div>
                    {{-- @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif --}}

                    <x-primary-button class="login-btn box-size">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
                <p class="partition">または新規アカウント作成</p>
                <a href="" class="go-register box-size">新規アカウント登録</a>
            </form>
        {{-- </div> --}}
    </div>

    <div class="test"></div>
    <div class="test"></div>
    <div class="test"></div>

<script src="{{asset('js/login.js') }}"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
AOS.init();
</script>
</x-guest-layout>
