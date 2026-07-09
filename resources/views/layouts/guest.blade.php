<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0369A1">
        <title>{{ config('app.name', 'WTA Recruitment') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50 min-h-screen flex flex-col">
        <header class="border-b border-slate-200 bg-white">
            <div class="container flex items-center h-16">
                <a href="{{ route('cv.create') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/WinThinLogo.png') }}" alt="WinThin Logo" class="h-9 w-auto">
                    <span class="font-display text-base font-semibold">{{ config('app.name', 'WTA Recruitment') }}</span>
                </a>
            </div>
        </header>

        <main class="flex-1 flex flex-col items-center justify-center px-4 py-8 sm:py-12">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="container py-4 text-sm text-slate-500 text-center">
                &copy; {{ date('Y') }} {{ config('app.name', 'WTA Recruitment') }}
            </div>
        </footer>
    </body>
</html>
