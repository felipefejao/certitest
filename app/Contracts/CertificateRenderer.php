<?php

namespace App\Contracts;

interface CertificateRenderer
{
    /**
     * Render SVG markup into PNG image bytes.
     */
    public function render(string $svg): string;
}
