<x-layouts.app-public>
    <x-slot:title>Application received</x-slot:title>

    <section class="container py-16 sm:py-24">
        <div class="max-w-xl mx-auto text-center">

            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-100 mb-6">
                <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">Thank you, {{ $application->name }}!</h1>
            <p class="mt-4 text-base sm:text-lg text-slate-600">
                Your application has been submitted successfully. Our team will review your CV and contact you about an interview.
            </p>

            <div class="mt-8 inline-flex flex-col items-center bg-white border border-slate-200 rounded-xl px-6 py-5 shadow-soft">
                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500">Reference number</p>
                <p class="mt-2 text-2xl font-mono font-bold text-brand-700 select-all">{{ $application->reference }}</p>
                <p class="mt-2 text-xs text-slate-500">Please keep this for your records.</p>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('cv.create') }}" class="btn-primary cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Submit another application
                </a>
                <a href="{{ route('login') }}" class="btn-secondary cursor-pointer">Admin login</a>
            </div>

            <p class="mt-8 text-xs text-slate-500">
                We typically respond within 3-5 business days. For urgent inquiries, contact us directly.
            </p>
        </div>
    </section>
</x-layouts.app-public>
