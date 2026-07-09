<x-guest-layout>
    <div class="mb-6 text-center">
        <img src="{{ asset('images/WinThinLogo.png') }}" alt="WinThin Logo" class="mx-auto h-12 w-auto">
        <h1 class="mt-4 font-display text-2xl font-bold tracking-tight text-slate-900">Admin sign in</h1>
        <p class="mt-1 text-sm text-slate-500">Access the recruitment console.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1.5 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-brand-700 shadow-soft focus:ring-brand-500 focus:ring-2" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-brand-700 hover:text-brand-800 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Sign in') }}
        </x-primary-button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        &larr; <a href="{{ route('cv.create') }}" class="text-brand-700 hover:text-brand-800 hover:underline">Back to public form</a>
    </p>
</x-guest-layout>
