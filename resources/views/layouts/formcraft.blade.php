<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#182241">
    <title>@yield('title', 'FormCraft')</title>
    @include('formcraft.styles')
    @stack('head')
</head>
<body class="@yield('body-class')" id="@yield('body-id', 'formcraft')">
    @yield('content')
    @stack('scripts')
</body>
</html>
