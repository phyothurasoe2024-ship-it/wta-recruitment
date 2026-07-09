<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCvApplicationRequest;
use App\Models\CvApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $query = CvApplication::query()->latest();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nrc', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        $applications = $query->paginate(15)->withQueryString();

        return view('admin.applications.index', [
            'applications' => $applications,
            'statuses'     => CvApplication::STATUSES,
            'search'       => $search,
            'currentStatus'=> $status,
        ]);
    }

    public function show(CvApplication $application): View
    {
        $application->load('reviewer');

        return view('admin.applications.show', [
            'application' => $application,
        ]);
    }

    public function update(UpdateCvApplicationRequest $request, CvApplication $application): RedirectResponse
    {
        $application->status      = $request->input('status');
        $application->admin_notes = $request->input('admin_notes');
        $application->reviewed_at = now();
        $application->reviewed_by = $request->user()?->id;
        $application->save();

        return redirect()
            ->route('admin.applications.show', $application)
            ->with('status', 'Application updated successfully.');
    }
}
