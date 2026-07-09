<x-layouts.admin>
    <x-slot:title>Applications</x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">Applications</h1>
            <p class="mt-1 text-sm text-slate-500">
                <span class="font-semibold text-slate-700 tabular-nums">{{ $applications->total() }}</span>
                {{ Str::plural('application', $applications->total()) }}
                @if($search || $currentStatus) matching your filters @endif
            </p>
        </div>
    </div>

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('admin.applications.index') }}" class="card p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <label for="search" class="sr-only">Search</label>
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="search" type="search" name="search" value="{{ $search }}" placeholder="Search by name, email, NRC, or reference..."
                       class="input pl-10">
            </div>
            <div class="sm:w-48">
                <label for="status" class="sr-only">Status</label>
                <select id="status" name="status" class="input">
                    <option value="">All statuses</option>
                    @foreach(\App\Models\CvApplication::STATUSES as $status)
                        <option value="{{ $status }}" @selected($currentStatus === $status)>
                            {{ \App\Models\CvApplication::STATUS_LABELS[$status] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="btn-primary cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                @if($search || $currentStatus)
                    <a href="{{ route('admin.applications.index') }}" class="btn-secondary cursor-pointer">Reset</a>
                @endif
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="card overflow-hidden">
        @if($applications->isEmpty())
            <div class="px-6 py-16 text-center">
                <svg class="mx-auto w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="mt-3 text-sm text-slate-500">No applications match your filters.</p>
                @if($search || $currentStatus)
                    <a href="{{ route('admin.applications.index') }}" class="mt-2 inline-block text-sm text-brand-700 hover:text-brand-800 hover:underline">Clear filters</a>
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th scope="col" class="px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Reference</th>
                            <th scope="col" class="px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Applicant</th>
                            <th scope="col" class="hidden lg:table-cell px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">NRC</th>
                            <th scope="col" class="hidden md:table-cell px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Contact</th>
                            <th scope="col" class="px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            <th scope="col" class="hidden sm:table-cell px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Submitted</th>
                            <th scope="col" class="px-5 sm:px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($applications as $app)
                            <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                <td class="px-5 sm:px-6 py-3 text-sm font-mono font-medium">
                                    <a href="{{ route('admin.applications.show', $app) }}" class="text-brand-700 hover:text-brand-800 hover:underline">{{ $app->reference }}</a>
                                </td>
                                <td class="px-5 sm:px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-white flex items-center justify-center text-sm font-semibold flex-shrink-0" aria-hidden="true">
                                            {{ strtoupper(substr($app->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-slate-900 truncate">{{ $app->name }}</p>
                                            <p class="text-xs text-slate-500 truncate sm:hidden">{{ $app->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden lg:table-cell px-5 sm:px-6 py-3 text-sm text-slate-600 font-mono">{{ $app->nrc }}</td>
                                <td class="hidden md:table-cell px-5 sm:px-6 py-3 text-sm">
                                    <a href="mailto:{{ $app->email }}" class="block text-slate-700 hover:text-brand-700 transition-colors duration-200 truncate max-w-[200px]">{{ $app->email }}</a>
                                    <a href="tel:{{ $app->phone }}" class="block text-xs text-slate-500 hover:text-brand-700 transition-colors duration-200">{{ $app->phone }}</a>
                                </td>
                                <td class="px-5 sm:px-6 py-3 text-sm">
                                    <span class="status-{{ $app->status }}">{{ $app->status_label }}</span>
                                </td>
                                <td class="hidden sm:table-cell px-5 sm:px-6 py-3 text-sm text-slate-500 tabular-nums">
                                    <div class="text-slate-700">{{ $app->created_at->format('Y-m-d') }}</div>
                                    <div class="text-xs text-slate-400">{{ $app->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-5 sm:px-6 py-3 text-right">
                                    <a href="{{ route('admin.applications.show', $app) }}"
                                       class="inline-flex items-center gap-1 text-sm font-medium text-brand-700 hover:text-brand-800 transition-colors duration-200 cursor-pointer">
                                        View
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($applications->hasPages())
                <div class="px-5 sm:px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                    {{ $applications->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.admin>
