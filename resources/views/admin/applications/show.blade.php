<x-layouts.admin>
    <x-slot:title>Application {{ $application->reference }}</x-slot:title>

    {{-- Breadcrumb / back link --}}
    <nav class="mb-4 text-sm" aria-label="Breadcrumb">
        <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center gap-1.5 text-slate-500 hover:text-brand-700 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to applications
        </a>
    </nav>

    {{-- Header --}}
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 text-white flex items-center justify-center text-xl sm:text-2xl font-display font-semibold flex-shrink-0" aria-hidden="true">
                {{ strtoupper(substr($application->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 truncate">{{ $application->name }}</h1>
                <p class="mt-1 text-sm text-slate-500 font-mono">{{ $application->reference }}</p>
            </div>
        </div>
        <span class="status-{{ $application->status }} text-sm self-start">{{ $application->status_label }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main column --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Personal info --}}
            <section class="card p-5 sm:p-6">
                <h2 class="font-display text-base font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-brand-100 text-brand-700" aria-hidden="true">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </span>
                    Personal information
                </h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-slate-500 text-xs uppercase tracking-wider font-semibold">Email</dt>
                        <dd class="mt-1 text-slate-900">
                            <a href="mailto:{{ $application->email }}" class="text-brand-700 hover:text-brand-800 hover:underline transition-colors duration-200 break-all">{{ $application->email }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 text-xs uppercase tracking-wider font-semibold">Phone</dt>
                        <dd class="mt-1 text-slate-900">
                            <a href="tel:{{ $application->phone }}" class="text-brand-700 hover:text-brand-800 hover:underline transition-colors duration-200">{{ $application->phone }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 text-xs uppercase tracking-wider font-semibold">NRC</dt>
                        <dd class="mt-1 text-slate-900 font-mono">{{ $application->nrc }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 text-xs uppercase tracking-wider font-semibold">Submitted</dt>
                        <dd class="mt-1 text-slate-900 tabular-nums">{{ $application->created_at->format('Y-m-d H:i') }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-slate-500 text-xs uppercase tracking-wider font-semibold">Address</dt>
                        <dd class="mt-1 text-slate-900 whitespace-pre-line">{{ $application->address }}</dd>
                    </div>
                </dl>
            </section>

            {{-- Work experience --}}
            @if($application->work_experience)
                <section class="card p-5 sm:p-6">
                    <h2 class="font-display text-base font-semibold text-slate-900 mb-3 flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-violet-100 text-violet-700" aria-hidden="true">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        Work experience
                    </h2>
                    <p class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">{{ $application->work_experience }}</p>
                </section>
            @endif

            {{-- Education --}}
            @if($application->education)
                <section class="card p-5 sm:p-6">
                    <h2 class="font-display text-base font-semibold text-slate-900 mb-3 flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-amber-100 text-amber-700" aria-hidden="true">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                            </svg>
                        </span>
                        Education
                    </h2>
                    <p class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">{{ $application->education }}</p>
                </section>
            @endif

            {{-- Why join --}}
            <section class="card p-5 sm:p-6">
                <h2 class="font-display text-base font-semibold text-slate-900 mb-3 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-emerald-100 text-emerald-700" aria-hidden="true">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </span>
                    Why join WTA
                </h2>
                <p class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">{{ $application->why_join_wta }}</p>
            </section>

            {{-- Attachments --}}
            <section class="card p-5 sm:p-6">
                <h2 class="font-display text-base font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-sky-100 text-sky-700" aria-hidden="true">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                    </span>
                    Attachments
                </h2>

                @php
                    $photoUrl   = $application->photo_path    ? route('admin.applications.files', ['application' => $application, 'type' => 'photo']) : null;
                    $nrcUrl     = $application->nrc_file_path ? route('admin.applications.files', ['application' => $application, 'type' => 'nrc'])   : null;
                    $photoExt   = $photoUrl ? strtolower(pathinfo($application->photo_path, PATHINFO_EXTENSION))    : null;
                    $nrcExt     = $nrcUrl   ? strtolower(pathinfo($application->nrc_file_path, PATHINFO_EXTENSION)) : null;
                    $isImage    = fn ($ext) => in_array($ext, ['jpg','jpeg','png','gif','webp'], true);
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Photo --}}
                    <div class="border border-slate-200 rounded-lg overflow-hidden hover:border-brand-300 transition-colors duration-200">
                        <div class="flex items-center justify-between gap-2 px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                            <div class="flex items-center gap-2 min-w-0">
                                <svg class="w-4 h-4 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-semibold text-slate-900 truncate">Photo</p>
                            </div>
                            @if($photoUrl)
                                <a href="{{ $photoUrl }}" download
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-brand-700 bg-white border border-slate-200 hover:bg-brand-50 hover:border-brand-300 transition-colors duration-200 cursor-pointer flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download
                                </a>
                            @endif
                        </div>
                        <div class="p-4 bg-slate-50">
                            @if($photoUrl && $isImage($photoExt))
                                <a href="{{ $photoUrl }}" target="_blank" rel="noopener" class="block group">
                                    <img src="{{ $photoUrl }}" alt="Applicant photo" loading="lazy"
                                         class="w-full max-h-80 object-contain rounded-md bg-white border border-slate-200 group-hover:border-brand-400 transition-colors duration-200">
                                    <p class="mt-2 text-center text-xs text-slate-500 group-hover:text-brand-700 transition-colors duration-200">Click to open full size</p>
                                </a>
                            @elseif($photoUrl)
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-slate-600 font-medium">.{{ strtoupper($photoExt) }} file</p>
                                    <a href="{{ $photoUrl }}" target="_blank" rel="noopener" class="mt-2 text-sm text-brand-700 hover:text-brand-800 hover:underline">Open file</a>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-slate-400 italic">No photo uploaded.</p>
                                </div>
                            @endif
                            @if($application->photo_path)
                                <p class="mt-3 text-[10px] text-slate-400 font-mono break-all">{{ $application->photo_path }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- NRC --}}
                    <div class="border border-slate-200 rounded-lg overflow-hidden hover:border-brand-300 transition-colors duration-200">
                        <div class="flex items-center justify-between gap-2 px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                            <div class="flex items-center gap-2 min-w-0">
                                <svg class="w-4 h-4 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-sm font-semibold text-slate-900 truncate">NRC attachment</p>
                            </div>
                            @if($nrcUrl)
                                <a href="{{ $nrcUrl }}" download
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-brand-700 bg-white border border-slate-200 hover:bg-brand-50 hover:border-brand-300 transition-colors duration-200 cursor-pointer flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download
                                </a>
                            @endif
                        </div>
                        <div class="p-4 bg-slate-50">
                            @if($nrcUrl && $isImage($nrcExt))
                                <a href="{{ $nrcUrl }}" target="_blank" rel="noopener" class="block group">
                                    <img src="{{ $nrcUrl }}" alt="NRC attachment" loading="lazy"
                                         class="w-full max-h-80 object-contain rounded-md bg-white border border-slate-200 group-hover:border-brand-400 transition-colors duration-200">
                                    <p class="mt-2 text-center text-xs text-slate-500 group-hover:text-brand-700 transition-colors duration-200">Click to open full size</p>
                                </a>
                            @elseif($nrcUrl && $nrcExt === 'pdf')
                                <div class="rounded-md overflow-hidden border border-slate-200 bg-white">
                                    <div class="flex items-center gap-2 px-3 py-2 bg-slate-50 border-b border-slate-200">
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 7V3.5L18.5 9H13z"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-slate-700">PDF document</span>
                                    </div>
                                    <iframe src="{{ $nrcUrl }}" title="NRC PDF preview"
                                            class="w-full h-80 bg-white" loading="lazy"></iframe>
                                </div>
                                <p class="mt-2 text-center text-xs text-slate-500">If the preview doesn't load, <a href="{{ $nrcUrl }}" target="_blank" rel="noopener" class="text-brand-700 hover:underline">open in a new tab</a>.</p>
                            @elseif($nrcUrl)
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-slate-600 font-medium">.{{ strtoupper($nrcExt) }} file</p>
                                    <a href="{{ $nrcUrl }}" target="_blank" rel="noopener" class="mt-2 text-sm text-brand-700 hover:text-brand-800 hover:underline">Open file</a>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-slate-400 italic">No NRC attachment uploaded.</p>
                                </div>
                            @endif
                            @if($application->nrc_file_path)
                                <p class="mt-3 text-[10px] text-slate-400 font-mono break-all">{{ $application->nrc_file_path }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- Sidebar: review --}}
        <aside class="space-y-6">
            <div class="card p-5 sm:p-6 sticky top-20">
                <h2 class="font-display text-base font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-brand-100 text-brand-700" aria-hidden="true">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </span>
                    Review
                </h2>

                <form method="POST" action="{{ route('admin.applications.update', $application) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="label">Status</label>
                        <select id="status" name="status" required
                                class="input {{ $errors->has('status') ? 'input-invalid' : '' }}">
                            @foreach(\App\Models\CvApplication::STATUSES as $status)
                                <option value="{{ $status }}" @selected($application->status === $status)>
                                    {{ \App\Models\CvApplication::STATUS_LABELS[$status] }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="admin_notes" class="label">Internal notes</label>
                        <textarea id="admin_notes" name="admin_notes" rows="6" maxlength="5000"
                                  placeholder="Add notes about the candidate..."
                                  class="input">{{ old('admin_notes', $application->admin_notes) }}</textarea>
                        <p class="help-text">Only visible to admins.</p>
                        @error('admin_notes') <p class="error-text" role="alert">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save review
                    </button>
                </form>

                @if($application->reviewed_at)
                    <div class="mt-5 pt-5 border-t border-slate-100">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Last review</p>
                        <p class="mt-1.5 text-sm text-slate-700">
                            {{ $application->reviewed_at->diffForHumans() }}
                            @if($application->reviewer)
                                <br>by <span class="font-medium">{{ $application->reviewer->name }}</span>
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </aside>
    </div>
</x-layouts.admin>
