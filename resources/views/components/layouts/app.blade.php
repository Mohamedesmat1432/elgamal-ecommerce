<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

    <link rel="stylesheet" href="{{ asset('css/site.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-slate-200 dark:bg-slate-700">

    <livewire:partials.navbar />

    <main>{{ $slot }}</main>

    <livewire:partials.footer />

    @livewireScripts

    <x-livewire-alert::scripts />
</body>

</html>
