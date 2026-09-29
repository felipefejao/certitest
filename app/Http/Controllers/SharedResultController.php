<?php

namespace App\Http\Controllers;

use App\Actions\Results\BuildCertificateSvgAction;
use App\Actions\Results\GetCertificatePngAction;
use App\Models\Attempt;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SharedResultController extends Controller
{
    public function show(string $publicToken): View
    {
        $attempt = $this->finishedAttempt($publicToken);

        return view('results.public', [
            'attempt' => $attempt,
            'exam' => $attempt->exam,
            'user' => $attempt->user,
        ]);
    }

    public function image(string $publicToken, BuildCertificateSvgAction $buildCertificateSvg): Response
    {
        $attempt = $this->finishedAttempt($publicToken);

        return response($buildCertificateSvg->handle($attempt), 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    public function imagePng(string $publicToken, GetCertificatePngAction $getCertificatePng): BinaryFileResponse
    {
        $attempt = $this->finishedAttempt($publicToken);

        return response()->file($getCertificatePng->handle($attempt), [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    private function finishedAttempt(string $publicToken): Attempt
    {
        return Attempt::with('exam', 'user')
            ->whereNotNull('finished_at')
            ->where('public_token', $publicToken)
            ->firstOrFail();
    }
}
