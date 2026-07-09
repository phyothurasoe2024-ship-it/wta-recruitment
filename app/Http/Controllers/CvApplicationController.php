<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvApplicationRequest;
use App\Models\CvApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CvApplicationController extends Controller
{
    public function create(): View
    {
        return view('cv.create');
    }

    public function store(StoreCvApplicationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $application = DB::transaction(function () use ($data, $request) {
            $application = new CvApplication();
            $application->reference       = $this->generateReference();
            $application->name            = $data['name'];
            $application->nrc             = $data['nrc'];
            $application->address         = $data['address'];
            $application->email           = $data['email'];
            $application->phone           = $data['phone'];
            $application->work_experience = $data['work_experience'] ?? null;
            $application->education       = $data['education'] ?? null;
            $application->why_join_wta    = $data['why_join_wta'];
            $application->status          = CvApplication::STATUS_PENDING;

            if ($request->hasFile('photo')) {
                $application->photo_path = $request->file('photo')
                    ->store('cvs/photo', 'public');
            }

            if ($request->hasFile('nrc_file')) {
                $application->nrc_file_path = $request->file('nrc_file')
                    ->store('cvs/nrc', 'public');
            }

            $application->save();

            return $application;
        });

        return redirect()
            ->route('cv.thank-you', ['reference' => $application->reference])
            ->with('applicant_name', $application->name);
    }

    public function thankYou(string $reference): View
    {
        $application = CvApplication::where('reference', $reference)->firstOrFail();

        return view('cv.thank-you', [
            'application' => $application,
        ]);
    }

    protected function generateReference(): string
    {
        $year = now()->format('Y');
        $count = CvApplication::whereYear('created_at', $year)->count() + 1;

        do {
            $reference = sprintf('WTA-%s-%04d', $year, $count);
            $count++;
        } while (CvApplication::where('reference', $reference)->exists());

        return $reference;
    }
}
