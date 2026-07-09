<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0369A1">
    <title>{{ $title ?? 'Admin' }} | {{ config('app.name', 'WTA Recruitment') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="font-sans text-slate-900 antialiased bg-slate-50 min-h-screen flex flex-col">

    <header class="sticky top-0 z-40 bg-white border-b border-slate-200">
        <div class="container flex items-center justify-between h-16">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/WinThinLogo.png') }}" alt="WinThin Logo" class="h-9 w-auto">
                    <div class="hidden sm:flex flex-col leading-tight">
                        <span class="font-display text-sm font-semibold text-slate-900">WTA Admin</span>
                        <span class="text-[10px] uppercase tracking-wider text-slate-400">Recruitment Console</span>
                    </div>
                </a>
                <nav class="hidden md:flex items-center gap-1 text-sm" aria-label="Main">
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-3 py-2 rounded-md font-medium transition-colors duration-200
                              {{ request()->routeIs('admin.dashboard') ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:text-brand-700 hover:bg-slate-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.applications.index') }}"
                       class="px-3 py-2 rounded-md font-medium transition-colors duration-200
                              {{ request()->routeIs('admin.applications.*') ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:text-brand-700 hover:bg-slate-100' }}">
                        Applications
                    </a>
                </nav>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('cv.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-md text-slate-600 hover:text-brand-700 hover:bg-slate-100 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Public form
                </a>
                <span class="hidden sm:inline text-slate-300">|</span>
                <div class="hidden sm:flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-xs font-semibold" aria-hidden="true">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-slate-700">{{ auth()->user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-md text-slate-600 hover:text-red-600 hover:bg-slate-100 transition-colors duration-200 cursor-pointer">
                        Logout
                    </button>
                </form>

                {{-- Mobile menu toggle --}}
                <button type="button" class="md:hidden p-2 rounded-md text-slate-600 hover:bg-slate-100 cursor-pointer"
                        @click="mobileNav = !mobileNav"
                        aria-label="Toggle navigation">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile nav --}}
        <nav class="md:hidden border-t border-slate-200 px-4 py-2 flex items-center gap-1 text-sm" aria-label="Mobile">
            <a href="{{ route('admin.dashboard') }}"
               class="flex-1 text-center px-3 py-2 rounded-md font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.dashboard') ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:bg-slate-100' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.applications.index') }}"
               class="flex-1 text-center px-3 py-2 rounded-md font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.applications.*') ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:bg-slate-100' }}">
                Applications
            </a>
        </nav>
    </header>

    @if (session('status'))
        <div class="container mt-4">
            <div role="alert" aria-live="polite" class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-emerald-800 font-medium">{{ session('status') }}</p>
            </div>
        </div>
    @endif

    <main class="flex-1 container py-6 sm:py-8">
        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="container py-4 text-sm text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'WTA Recruitment') }} &middot; Admin</p>
            <p class="text-xs">v1.0</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
