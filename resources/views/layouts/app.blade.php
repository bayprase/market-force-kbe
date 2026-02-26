<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body>
        <div class="template grid grid-cols-1 md:grid-cols-[0.3fr_2fr] bg-gray-200">
            <livewire:components.sidebar title="Dashboard" />
            {{ $slot }}
        </div>
        @livewireScripts
    </body>
</html>
