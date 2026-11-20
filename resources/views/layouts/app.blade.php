<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts and palette: self-hosted, see public/formcraft/fonts.css -->
        @foreach (['fonts', 'palette'] as $sheet)
            <link rel="stylesheet" href="{{ asset("formcraft/{$sheet}.css") }}?v={{ filemtime(public_path("formcraft/{$sheet}.css")) }}">
        @endforeach

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @if (request()->routeIs('dashboard'))
            @include('formcraft.styles')
            @include('formcraft.form-list-styles')
            <link rel="stylesheet" href="{{ asset('formcraft/account.css') }}">
            @include('formcraft.scripts')
        @endif
    </head>
    <body @class(['font-sans antialiased', 'formcraft-workspace' => request()->routeIs('dashboard')])>
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
