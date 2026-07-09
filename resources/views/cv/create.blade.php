<x-layouts.app-public>
    <x-slot:title>Apply to join WTA</x-slot:title>

    @push('styles')
        <style>
            .step-active   { @apply border-brand-700 text-brand-700; }
            .step-inactive { @apply border-slate-200 text-slate-400; }
        </style>
    @endpush

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-brand-700 via-brand-700 to-brand-900 text-white">
        <div class="absolute inset-0 opacity-10" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)"/>
            </svg>
        </div>
        <div class="container relative py-12 sm:py-16 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white mb-6 ring-1 ring-white/30 shadow-lg p-2">
                <img src="{{ asset('images/WinThinLogo.png') }}" alt="WinThin Logo" class="h-14 w-14 sm:h-16 sm:w-16">
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-slate-900" style="color: white; font-weight: bold;"~~>Join the WTA Team</h1>
            <p class="mt-4 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto" style="color: white; font-weight: bold;">
                Submit your CV and we'll get back to you about an interview. The form takes about 3 minutes.
            </p>

            {{-- Stepper --}}
            <ol class="mt-8 flex items-center justify-center gap-2 sm:gap-4 max-w-2xl mx-auto" aria-label="Form progress">
                @php
                    $steps = [
                        ['label' => 'Personal', 'active' => true],
                        ['label' => 'Documents', 'active' => false],
                        ['label' => 'Background', 'active' => false],
                        ['label' => 'Review', 'active' => false],
                    ];
                @endphp
                @foreach($steps as $i => $step)
                    <li class="flex items-center gap-2 sm:gap-3 {{ $loop->last ? '' : 'flex-1' }}">
                        <span class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 rounded-full text-xs font-semibold border-2 {{ $step['active'] ? 'bg-white text-brand-700 border-white' : 'bg-transparent text-white border-white/40' }}"
                              aria-current="{{ $step['active'] ? 'step' : 'false' }}">
                            {{ $i + 1 }}
                        </span>
                        <span class="hidden sm:inline text-sm font-medium {{ $step['active'] ? 'text-white' : 'text-brand-200' }}">{{ $step['label'] }}</span>
                        @unless($loop->last)
                            <span class="flex-1 h-px bg-white/30" aria-hidden="true"></span>
                        @endunless
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Form --}}
    <section class="container -mt-8 sm:-mt-12 pb-16 relative z-10">
        <div class="max-w-3xl mx-auto">

            @if ($errors->any())
                <div role="alert" aria-live="assertive" class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 sm:p-5">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.94 6.94a1.5 1.5 0 112.12 2.12L10 10.12l-1.06 1.06a1.5 1.5 0 11-2.12-2.12L7.88 10 6.82 8.94a1.5 1.5 0 112.12-2.12L10 7.88l1.06-1.06a1.5 1.5 0 112.12 2.12L10.12 10l1.06 1.06a1.5 1.5 0 11-2.12 2.12L10 12.12l-1.06 1.06a1.5 1.5 0 11-2.12-2.12L7.88 10 6.82 8.94z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-red-800">Please correct the following errors:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('cv.store') }}" enctype="multipart/form-data"
                  class="card p-6 sm:p-8 space-y-8"
                  id="cv-form"
                  onsubmit="var b=this.querySelector('button[type=submit]'); b.disabled=true; b.querySelector('.btn-label').classList.add('hidden'); b.querySelector('.btn-loader').classList.remove('hidden');">

                @csrf

                {{-- Section: Personal --}}
                <fieldset>
                    <legend class="font-display text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-brand-100 text-brand-700 text-sm font-semibold">1</span>
                        Personal information
                    </legend>
                    <p class="mt-1 text-sm text-slate-500">Tell us who you are.</p>

                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="label">Full name <span class="text-red-500" aria-hidden="true">*</span></label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="120"
                                   autocomplete="name"
                                   aria-required="true"
                                   aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                                   class="input {{ $errors->has('name') ? 'input-invalid' : '' }}">
                            @error('name') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="nrc" class="label">NRC number <span class="text-red-500" aria-hidden="true">*</span></label>
                            <input id="nrc" type="text" name="nrc" value="{{ old('nrc') }}" required maxlength="60"
                                   placeholder="e.g. 12/ABC(N)123456"
                                   aria-required="true"
                                   aria-invalid="{{ $errors->has('nrc') ? 'true' : 'false' }}"
                                   class="input {{ $errors->has('nrc') ? 'input-invalid' : '' }}">
                            @error('nrc') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="label">Address <span class="text-red-500" aria-hidden="true">*</span></label>
                            <textarea id="address" name="address" rows="2" required maxlength="1000"
                                      aria-required="true"
                                      aria-invalid="{{ $errors->has('address') ? 'true' : 'false' }}"
                                      class="input {{ $errors->has('address') ? 'input-invalid' : '' }}">{{ old('address') }}</textarea>
                            @error('address') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="label">Email <span class="text-red-500" aria-hidden="true">*</span></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="160"
                                   autocomplete="email"
                                   aria-required="true"
                                   aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                   class="input {{ $errors->has('email') ? 'input-invalid' : '' }}">
                            @error('email') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="phone" class="label">Phone <span class="text-red-500" aria-hidden="true">*</span></label>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required maxlength="40"
                                   autocomplete="tel"
                                   placeholder="+95 9 123 456 789"
                                   aria-required="true"
                                   aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                   class="input {{ $errors->has('phone') ? 'input-invalid' : '' }}">
                            @error('phone') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </fieldset>

                {{-- Section: Documents --}}
                <fieldset>
                    <legend class="font-display text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-brand-100 text-brand-700 text-sm font-semibold">2</span>
                        Documents
                    </legend>
                    <p class="mt-1 text-sm text-slate-500">Upload your photo and NRC scan (both optional but recommended).</p>

                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="photo" class="label">Photo</label>
                            <input id="photo" type="file" name="photo" accept="image/jpeg,image/png"
                                   aria-describedby="photo-help"
                                   class="block w-full text-sm text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-brand-50 file:text-brand-700 file:font-semibold hover:file:bg-brand-100 transition-colors duration-200">
                            <p id="photo-help" class="help-text">JPG, JPEG or PNG &middot; max 2 MB</p>
                            @error('photo') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="nrc_file" class="label">NRC attachment</label>
                            <input id="nrc_file" type="file" name="nrc_file" accept="image/jpeg,image/png,application/pdf"
                                   aria-describedby="nrc-help"
                                   class="block w-full text-sm text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-brand-50 file:text-brand-700 file:font-semibold hover:file:bg-brand-100 transition-colors duration-200">
                            <p id="nrc-help" class="help-text">JPG, PNG or PDF &middot; max 4 MB</p>
                            @error('nrc_file') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </fieldset>

                {{-- Section: Background --}}
                <fieldset>
                    <legend class="font-display text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-brand-100 text-brand-700 text-sm font-semibold">3</span>
                        Background
                    </legend>
                    <p class="mt-1 text-sm text-slate-500">Help us understand your experience and motivation.</p>

                    <div class="mt-5 space-y-5">
                        <div>
                            <label for="work_experience" class="label">Work experience</label>
                            <textarea id="work_experience" name="work_experience" rows="5" maxlength="5000"
                                      placeholder="List your previous roles, companies, and dates."
                                      class="input">{{ old('work_experience') }}</textarea>
                            <p class="help-text">Optional &middot; up to 5,000 characters</p>
                            @error('work_experience') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="education" class="label">Education</label>
                            <textarea id="education" name="education" rows="4" maxlength="5000"
                                      placeholder="List your schools, degrees, and graduation years."
                                      class="input">{{ old('education') }}</textarea>
                            <p class="help-text">Optional &middot; up to 5,000 characters</p>
                            @error('education') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="why_join_wta" class="label">Why do you want to join WTA? <span class="text-red-500" aria-hidden="true">*</span></label>
                            <textarea id="why_join_wta" name="why_join_wta" rows="5" required minlength="20" maxlength="5000"
                                      placeholder="Tell us why you are interested in joining WTA (minimum 20 characters)."
                                      aria-required="true"
                                      aria-invalid="{{ $errors->has('why_join_wta') ? 'true' : 'false' }}"
                                      class="input {{ $errors->has('why_join_wta') ? 'input-invalid' : '' }}">{{ old('why_join_wta') }}</textarea>
                            <p class="help-text">Required &middot; minimum 20 characters</p>
                            @error('why_join_wta') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </fieldset>

                {{-- Actions --}}
                <div class="pt-6 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-xs text-slate-500">By submitting, you confirm that the information provided is accurate.</p>
                    <div class="flex items-center gap-3">
                        <button type="reset" class="btn-secondary cursor-pointer">Clear</button>
                        <button type="submit"
                                class="btn-primary min-w-[10rem] cursor-pointer disabled:opacity-70">
                            <span class="btn-label inline-flex items-center gap-2">Submit application</span>
                            <span class="btn-loader hidden inline-flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                Submitting...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</x-layouts.app-public>
