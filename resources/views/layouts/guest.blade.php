<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @if (request()->routeIs('login', 'register'))
            <link rel="stylesheet" href="{{ asset('formcraft/fonts.css') }}">
            <link rel="stylesheet" href="{{ asset('formcraft/account.css') }}">
        @endif
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @if (request()->routeIs('login', 'register'))
        <main class="formcraft-auth">
            <div class="auth-intro">
                <a class="auth-brand" href="{{ route('formcraft.home') }}">FormCraft<span>.</span></a>
                <p>{{ request()->routeIs('register') ? 'Çalışma alanını kur.' : 'Çalışma alanına dön.' }}</p>
                <a href="{{ route('formcraft.preview.builder') }}">Form kurucuyu keşfet ↗</a>
            </div>
            <div class="auth-paper">
                <h1>{{ request()->routeIs('register') ? 'Hesap aç' : 'Giriş yap' }}</h1>
                {{ $slot }}
                @if (request()->routeIs('login'))
                    <a class="auth-alternate" href="{{ route('register') }}">Yeni hesap aç ↗</a>
                @endif
            </div>
        </main>
        @else
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        @endif
    </body>
</html>
