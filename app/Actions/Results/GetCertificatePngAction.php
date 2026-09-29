<?php

namespace App\Actions\Results;

use App\Contracts\CertificateRenderer;
use App\Models\Attempt;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class GetCertificatePngAction
{
    public function __construct(
        private BuildCertificateSvgAction $buildCertificateSvg,
        private CertificateRenderer $certificateRenderer,
    ) {}

    public function handle(Attempt $attempt): string
    {
        if ($attempt->finished_at === null) {
            throw (new ModelNotFoundException)->setModel(Attempt::class, $attempt->id);
        }

        $disk = Storage::disk('local');
        $path = "certificates/{$attempt->public_token}.png";

        if (! $disk->exists($path)) {
            $disk->put($path, $this->certificateRenderer->render(
                $this->buildCertificateSvg->handle($attempt)
            ));
        }

        return $disk->path($path);
    }
}
