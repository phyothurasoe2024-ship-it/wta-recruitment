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
    <body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col">
        <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200">
            <div class="container flex items-center justify-between h-16">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/WinThinLogo.png') }}" alt="WinThin Logo" class="h-9 w-auto">
                    <span class="font-display text-base font-semibold">{{ config('app.name', 'WTA Recruitment') }}</span>
                </a>
                <div class="flex items-center gap-2 text-sm">
                    <a href="{{ route('cv.create') }}" class="px-3 py-2 rounded-md text-slate-600 hover:text-brand-700 hover:bg-slate-100 transition-colors duration-200">Public form</a>
                    <span class="text-slate-300">|</span>
                    <span class="text-slate-700 hidden sm:inline">{{ auth()->user()?->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-md text-slate-600 hover:text-red-600 hover:bg-slate-100 transition-colors duration-200 cursor-pointer">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="bg-white border-t border-slate-200 mt-auto">
            <div class="container py-4 text-sm text-slate-500 text-center">
                &copy; {{ date('Y') }} {{ config('app.name', 'WTA Recruitment') }}
            </div>
        </footer>
    </body>
</html>
