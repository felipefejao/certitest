<?php

namespace App\Services\Certificate;

use App\Contracts\CertificateRenderer;
use Imagick;
use ImagickPixel;
use RuntimeException;

class ImagickCertificateRenderer implements CertificateRenderer
{
    public const int WIDTH = 1200;

    public const int HEIGHT = 630;

    public function render(string $svg): string
    {
        if (! extension_loaded('imagick')) {
            throw new RuntimeException('A extensão imagick é necessária para renderizar o certificado em PNG.');
        }

        $imagick = new Imagick;
        $imagick->setBackgroundColor(new ImagickPixel('#ffffff'));
        $imagick->readImageBlob($svg);
        $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
        $imagick->setImageFormat('png');

        if ($imagick->getImageWidth() !== self::WIDTH || $imagick->getImageHeight() !== self::HEIGHT) {
            $imagick->resizeImage(self::WIDTH, self::HEIGHT, Imagick::FILTER_LANCZOS, 1);
        }

        $png = $imagick->getImageBlob();
        $imagick->clear();

        return $png;
    }
}
