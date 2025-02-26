<x-guest-layout css="start">
    <div class="container">
        <h1><a href="{{ route('start') }}">わんダムウォーク</a></h1>
        <p></p>
        {{-- <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"> --}}

            <!-- Session Status -->
            <x-auth-session-status :status="session('status')" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="input-group">
                    <x-input-label class="label" for="name2" :value="__('Name')" />
                    <x-text-input class="form box-size" id="name2" disabled type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    {{-- <x-input-error :messages="$errors->get('name')" class="mt-2" /> --}}
                </div>

                <!-- Password -->
                <div class="input-group">
                    <x-input-label class="label" for="password2" :value="__('Password')" />

                    <x-text-input class="form box-size" id="password2" disabled
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <x-input-label class="label" for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input class="form box-size" id="password_confirmation" disabled
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" />
                </div>

                <div>
                    <x-primary-button class="login-or-register-btn box-size">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
                <p class="partition">またはログイン</p>
                <a href="{{ route('login') }}" class="switch-page box-size">ログイン</a>
            </form>
        {{-- </div> --}}
    </div>
<script src="{{asset('js/login.js') }}"></script>
</x-guest-layout>
