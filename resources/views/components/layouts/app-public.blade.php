<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0369A1">
    <title>{{ $title ?? config('app.name', 'WTA Recruitment') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="font-sans text-slate-900 antialiased bg-slate-50 min-h-screen flex flex-col">

    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="container flex items-center justify-between h-16">
            <a href="{{ route('cv.create') }}" class="flex items-center gap-3 group focus-visible:outline-none">
                <img src="{{ asset('images/WinThinLogo.png') }}" alt="WinThin Logo" class="h-9 w-auto transition-transform duration-200 group-hover:scale-105">
                <span class="hidden sm:inline font-display text-base font-semibold text-slate-900">{{ config('app.name', 'WTA Recruitment') }}</span>
            </a>
            <nav class="flex items-center gap-1 sm:gap-2 text-sm">
                <a href="{{ route('cv.create') }}"
                   class="px-3 py-2 rounded-md font-medium text-slate-600 hover:text-brand-700 hover:bg-slate-100 transition-colors duration-200
                          {{ request()->routeIs('cv.create') ? 'text-brand-700 bg-brand-50' : '' }}">
                    Apply
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-3 py-2 rounded-md font-medium text-slate-600 hover:text-brand-700 hover:bg-slate-100 transition-colors duration-200">
                            Admin
                        </a>
                    @endif
                    <span class="hidden sm:inline text-slate-400 mx-1">|</span>
                    <span class="hidden sm:inline text-slate-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-md font-medium text-slate-600 hover:text-red-600 hover:bg-slate-100 transition-colors duration-200 cursor-pointer">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="px-3 py-2 rounded-md font-medium text-slate-600 hover:text-brand-700 hover:bg-slate-100 transition-colors duration-200
                              {{ request()->routeIs('login') ? 'text-brand-700 bg-brand-50' : '' }}">
                        Admin Login
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main id="main" class="flex-1">
        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="container py-6 text-sm text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'WTA Recruitment') }}. All rights reserved.</p>
            <p class="text-xs">Powered by WinThin Associates</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
