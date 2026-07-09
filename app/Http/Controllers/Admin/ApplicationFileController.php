<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationFileController extends Controller
{
    public function show(Request $request, CvApplication $application, string $type): StreamedResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $path = match ($type) {
            'photo'    => $application->photo_path,
            'nrc'      => $application->nrc_file_path,
            default    => abort(404),
        };

        abort_if(empty($path), 404, 'File not found.');
        abort_unless(Storage::disk('public')->exists($path), 404, 'File missing on disk.');

        $absolutePath = Storage::disk('public')->path($path);
        $mime         = Storage::disk('public')->mimeType($path) ?: 'application/octet-stream';
        $filename     = sprintf('%s_%s_%s', $application->reference, $type, basename($path));

        return response()->streamDownload(function () use ($absolutePath) {
            $stream = fopen($absolutePath, 'rb');
            if ($stream === false) {
                return;
            }
            while (! feof($stream)) {
                echo fread($stream, 8192);
                flush();
            }
            fclose($stream);
        }, $filename, [
            'Content-Type' => $mime,
        ]);
    }
}
