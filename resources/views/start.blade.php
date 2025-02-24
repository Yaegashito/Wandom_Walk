<x-guest-layout css="start">
<main>
    <h1>わんダムウォーク</h1>
    <p>愛犬と、最期まで健康的に</p>
    <img src="{{ asset('img/favicon2.png') }}" alt="イメージ画像です">
</main>
<div class="guide">
    <a href="{{ route('login') }}" class="go-login">はじめる</a>
    <a href="{{ route('explanation') }}" class="go-register">わんダムウォークとは？</a>
</div>
<script src="{{asset('js/login.js') }}"></script>
</x-guest-layout>
