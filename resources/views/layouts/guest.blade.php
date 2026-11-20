@php
    $screens = [
        'login' => ['Çalışma alanına dön.', 'Giriş yap'],
        'register' => ['Çalışma alanını kur.', 'Hesap aç'],
        'password.request' => ['Şifreni yenile.', 'Şifremi unuttum'],
        'password.reset' => ['Yeni şifreni belirle.', 'Şifreyi sıfırla'],
        'verification.notice' => ['E-postanı doğrula.', 'E-posta doğrulama'],
        'password.confirm' => ['Güvenli alana gir.', 'Şifreni onayla'],
    ];
    [$intro, $heading] = $screens[request()->route()?->getName()] ?? ['FormCraft', 'FormCraft'];
@endphp
<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#17213C">

        <title>{{ $heading }} · FormCraft</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('formcraft/fonts.css') }}?v={{ filemtime(public_path('formcraft/fonts.css')) }}">
        <link rel="stylesheet" href="{{ asset('formcraft/palette.css') }}?v={{ filemtime(public_path('formcraft/palette.css')) }}">
        <link rel="stylesheet" href="{{ asset('formcraft/account.css') }}?v={{ filemtime(public_path('formcraft/account.css')) }}">
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <main class="formcraft-auth">
            <div class="auth-intro">
                <a class="auth-brand" href="{{ route('formcraft.home') }}">FormCraft<span>.</span></a>
                <p>{{ $intro }}</p>
                <a href="{{ route('formcraft.preview.builder') }}">Form kurucuyu keşfet ↗</a>
            </div>
            <div class="auth-paper">
                <h1>{{ $heading }}</h1>
                {{ $slot }}
                @if (request()->routeIs('login'))
                    <a class="auth-alternate" href="{{ route('register') }}">Yeni hesap aç ↗</a>
                @elseif (request()->routeIs('password.request'))
                    <a class="auth-alternate" href="{{ route('login') }}">Girişe dön ↗</a>
                @endif
            </div>
        </main>
    </body>
</html>
