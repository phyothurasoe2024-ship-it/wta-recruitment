<?php

use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\ApplicationFileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CvApplicationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('cv.create');
});

Route::get('/apply', [CvApplicationController::class, 'create'])->name('cv.create');
Route::post('/apply', [CvApplicationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('cv.store');
Route::get('/apply/thank-you/{reference}', [CvApplicationController::class, 'thankYou'])
    ->name('cv.thank-you');

Route::get('/dashboard', function () {
    if (auth()->user()?->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}', [AdminApplicationController::class, 'update'])->name('applications.update');

        Route::get('/applications/{application}/files/{type}', [ApplicationFileController::class, 'show'])
            ->where('type', 'photo|nrc')
            ->name('applications.files');
    });

require __DIR__.'/auth.php';
