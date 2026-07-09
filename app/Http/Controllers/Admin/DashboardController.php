<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvApplication;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $counts = CvApplication::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $stats = [
            'total'         => array_sum($counts),
            'pending'       => $counts[CvApplication::STATUS_PENDING]       ?? 0,
            'under_review'  => $counts[CvApplication::STATUS_UNDER_REVIEW]  ?? 0,
            'interview'     => $counts[CvApplication::STATUS_INTERVIEW]     ?? 0,
            'accepted'      => $counts[CvApplication::STATUS_ACCEPTED]      ?? 0,
            'rejected'      => $counts[CvApplication::STATUS_REJECTED]      ?? 0,
        ];

        $recent = CvApplication::latest()->limit(10)->get();

        return view('admin.dashboard', [
            'stats'  => $stats,
            'recent' => $recent,
        ]);
    }
}
