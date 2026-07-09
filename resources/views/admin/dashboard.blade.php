<x-layouts.admin>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">Dashboard</h1>
            <p class="mt-1 text-sm text-slate-500">Overview of CV applications received.</p>
        </div>
        <a href="{{ route('admin.applications.index') }}" class="btn-secondary cursor-pointer self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            View all applications
        </a>
    </div>

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-8">
        @php
            $statCards = [
                ['key' => 'total',        'label' => 'Total',        'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'slate'],
                ['key' => 'pending',      'label' => 'Pending',      'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber'],
                ['key' => 'under_review', 'label' => 'Under review', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'sky'],
                ['key' => 'interview',    'label' => 'Interview',    'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'violet'],
                ['key' => 'accepted',     'label' => 'Accepted',     'icon' => 'M5 13l4 4L19 7', 'color' => 'emerald'],
                ['key' => 'rejected',     'label' => 'Rejected',     'icon' => 'M6 18L18 6M6 6l12 12', 'color' => 'rose'],
            ];
        @endphp

        @foreach($statCards as $card)
            <div class="card p-4 sm:p-5 transition-shadow duration-200 hover:shadow-card">
                <div class="flex items-start justify-between gap-2">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $card['label'] }}</p>
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                        </svg>
                    </span>
                </div>
                <p class="mt-3 text-2xl sm:text-3xl font-bold font-display text-slate-900 tabular-nums">{{ number_format($stats[$card['key']] ?? 0) }}</p>
            </div>
        @endforeach
    </div>

    {{-- Recent applications --}}
    <div class="card overflow-hidden">
        <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="font-display text-base sm:text-lg font-semibold text-slate-900">Recent applications</h2>
                <p class="text-xs text-slate-500 mt-0.5">Latest 10 submissions</p>
            </div>
            <a href="{{ route('admin.applications.index') }}" class="text-sm font-medium text-brand-700 hover:text-brand-800 transition-colors duration-200">
                View all &rarr;
            </a>
        </div>

        @if($recent->isEmpty())
            <div class="px-6 py-16 text-center">
                <svg class="mx-auto w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="mt-3 text-sm text-slate-500">No applications yet.</p>
                <p class="mt-1 text-xs text-slate-400">When candidates submit the CV form, they'll appear here.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th scope="col" class="px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Reference</th>
                            <th scope="col" class="px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Name</th>
                            <th scope="col" class="hidden md:table-cell px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Email</th>
                            <th scope="col" class="hidden lg:table-cell px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Phone</th>
                            <th scope="col" class="px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            <th scope="col" class="hidden sm:table-cell px-5 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Submitted</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recent as $app)
                            <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                <td class="px-5 sm:px-6 py-3 text-sm font-mono font-medium">
                                    <a href="{{ route('admin.applications.show', $app) }}" class="text-brand-700 hover:text-brand-800 hover:underline">{{ $app->reference }}</a>
                                </td>
                                <td class="px-5 sm:px-6 py-3 text-sm text-slate-900 font-medium">{{ $app->name }}</td>
                                <td class="hidden md:table-cell px-5 sm:px-6 py-3 text-sm text-slate-600">
                                    <a href="mailto:{{ $app->email }}" class="hover:text-brand-700 transition-colors duration-200">{{ $app->email }}</a>
                                </td>
                                <td class="hidden lg:table-cell px-5 sm:px-6 py-3 text-sm text-slate-600">
                                    <a href="tel:{{ $app->phone }}" class="hover:text-brand-700 transition-colors duration-200">{{ $app->phone }}</a>
                                </td>
                                <td class="px-5 sm:px-6 py-3 text-sm">
                                    <span class="status-{{ $app->status }}">{{ $app->status_label }}</span>
                                </td>
                                <td class="hidden sm:table-cell px-5 sm:px-6 py-3 text-sm text-slate-500 tabular-nums">{{ $app->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.admin>
