<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class SharedResultController extends Controller
{
    public function show(string $publicToken): View
    {
        $attempt = Attempt::with('exam', 'user')
            ->whereNotNull('finished_at')
            ->where('public_token', $publicToken)
            ->firstOrFail();

        return view('results.public', [
            'attempt' => $attempt,
            'exam' => $attempt->exam,
            'user' => $attempt->user,
        ]);
    }

    public function image(string $publicToken): Response
    {
        $attempt = Attempt::with('exam', 'user')
            ->whereNotNull('finished_at')
            ->where('public_token', $publicToken)
            ->firstOrFail();

        $path = $this->generateShareImage($attempt);

        return new BinaryFileResponse($path, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    private function generateShareImage(Attempt $attempt): string
    {
        $width = 1200;
        $height = 630;
        $padding = 60;

        $image = imagecreatetruecolor($width, $height);

        $background = imagecolorallocate($image, 247, 244, 239);
        $border = imagecolorallocate($image, 200, 191, 178);
        $dark = imagecolorallocate($image, 46, 46, 46);
        $muted = imagecolorallocate($image, 100, 92, 82);
        $accent = imagecolorallocate($image, 196, 75, 43);
        $light = imagecolorallocate($image, 220, 215, 205);
        $barBackground = imagecolorallocate($image, 220, 220, 220);
        $barFill = imagecolorallocate($image, 196, 75, 43);

        imagefill($image, 0, 0, $background);

        $this->drawCertificateBorder($image, $width, $height, $padding, $border);

        $font = $this->resolveFontPath();
        $boldFont = $this->resolveBoldFontPath();

        $name = $attempt->user->name;
        $examName = $attempt->exam->name;
        $percentage = (float) $attempt->percentage;
        $correct = $attempt->correct_answers;
        $total = $attempt->total_questions;

        $this->drawShield($image, $padding + 25, $padding + 18, 45, $dark);
        $this->drawText($image, 'CertiTest', $boldFont, 40, $padding + 64, $dark, 'left', $padding + 82);

        imageline($image, $padding + 25, $padding + 85, $width - $padding - 25, $padding + 85, $light);

        $this->drawText($image, 'OFFICIAL SIMULATED EXAM CERTIFICATE', $font, 16, $padding + 105, $muted, 'left', $padding + 25);
        $this->drawText($image, 'CANDIDATE: '.strtoupper($name), $boldFont, 16, $padding + 105, $dark, 'right', $width - $padding - 25);

        $titleLines = $this->wrapText($examName, $boldFont, 38, $width - ($padding * 2) - 120);
        $titleY = 220;
        foreach ($titleLines as $line) {
            $this->drawCenteredText($image, $line, $boldFont, 38, $titleY, $dark);
            $titleY += 50;
        }

        $scoreY = 410;
        $scoreX = 420;
        $this->drawText($image, sprintf('%.0f%%', $percentage), $boldFont, 120, $scoreY, $accent, 'left', $scoreX);

        $barX = $scoreX + 240;
        $barY = $scoreY - 50;
        $barWidth = 160;
        $barHeight = 22;
        imagefilledrectangle($image, $barX, $barY, $barX + $barWidth, $barY + $barHeight, $barBackground);

        if ($total > 0) {
            $fillWidth = (int) ($barWidth * ($correct / $total));
            imagefilledrectangle($image, $barX, $barY, $barX + $fillWidth, $barY + $barHeight, $barFill);
        }

        $correctAnswersY = $scoreY + 52;
        $this->drawCenteredText($image, sprintf('%d/%d correct answers', $correct, $total), $font, 26, $correctAnswersY, $muted);

        $testKnowledgeY = $correctAnswersY + 45;
        $this->drawCenteredText($image, 'Test your knowledge on CertiTest', $font, 24, $testKnowledgeY, $dark);

        $signatureFont = $this->resolveSignatureFontPath() ?? $font;

        $this->drawSignatureLine($image, $padding + 80, $height - $padding - 40, 240);
        $this->drawText($image, 'CertiTest', $signatureFont, 34, $height - $padding - 50, $dark, 'left', $padding + 80);
        $this->drawText($image, 'Authorized CertiTest Examiner', $font, 14, $height - $padding - 20, $muted, 'left', $padding + 80);

        $dateText = $attempt->finished_at?->format('d/m/Y') ?? now()->format('d/m/Y');
        $this->drawText($image, 'Document Date: '.$dateText, $font, 16, $height - $padding - 25, $dark, 'right', $width - $padding - 80);

        $directory = storage_path('app/share-results');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory.'/result-'.$attempt->public_token.'.png';
        imagepng($image, $path);
        imagedestroy($image);

        return $path;
    }

    private function drawCertificateBorder($image, int $width, int $height, int $padding, int $color): void
    {
        $x1 = $padding;
        $y1 = $padding;
        $x2 = $width - $padding;
        $y2 = $height - $padding;

        imagerectangle($image, $x1, $y1, $x2, $y2, $color);
        imagerectangle($image, $x1 + 8, $y1 + 8, $x2 - 8, $y2 - 8, $color);

        $cornerRadius = 20;
        $this->drawCorner($image, $x1, $y1, $cornerRadius, $color);
        $this->drawCorner($image, $x2, $y1, $cornerRadius, $color, true);
        $this->drawCorner($image, $x1, $y2, $cornerRadius, $color, false, true);
        $this->drawCorner($image, $x2, $y2, $cornerRadius, $color, true, true);
    }

    private function drawCorner($image, int $cx, int $cy, int $radius, int $color, bool $flipX = false, bool $flipY = false): void
    {
        for ($i = 0; $i < 6; $i++) {
            $offset = $i * 6;
            $startX = $flipX ? $cx - $radius - $offset : $cx + $radius + $offset;
            $startY = $flipY ? $cy - $radius - $offset : $cy + $radius + $offset;
            $endX = $flipX ? $cx - $offset : $cx + $offset;
            $endY = $flipY ? $cy - $offset : $cy + $offset;

            imageline($image, $startX, $startY, $endX, $endY, $color);
            imageline($image, $startY, $startX, $endY, $endX, $color);
        }
    }

    private function drawShield($image, int $x, int $y, int $size, int $color): void
    {
        $points = [
            $x + $size * 0.5, $y,
            $x + $size, $y + $size * 0.2,
            $x + $size * 0.85, $y + $size * 0.6,
            $x + $size * 0.5, $y + $size,
            $x + $size * 0.15, $y + $size * 0.6,
            $x, $y + $size * 0.2,
        ];

        imagepolygon($image, $points, $color);

        $checkColor = imagecolorallocatealpha($image, 247, 244, 239, 0);
        $checkPoints = [
            $x + $size * 0.25, $y + $size * 0.45,
            $x + $size * 0.4, $y + $size * 0.65,
            $x + $size * 0.75, $y + $size * 0.28,
        ];
        imageline($image, (int) $checkPoints[0], (int) $checkPoints[1], (int) $checkPoints[2], (int) $checkPoints[3], $checkColor);
        imageline($image, (int) $checkPoints[2], (int) $checkPoints[3], (int) $checkPoints[4], (int) $checkPoints[5], $checkColor);
    }

    private function drawSignatureLine($image, int $x, int $y, int $width): void
    {
        $color = imagecolorallocate($image, 46, 46, 46);

        for ($i = 0; $i < $width; $i++) {
            $waveY = $y + (int) (sin($i / 12) * 6);
            imagesetpixel($image, $x + $i, $waveY, $color);
        }
    }

    private function drawCenteredText($image, string $text, ?string $font, int $size, int $y, int $color): void
    {
        $this->drawText($image, $text, $font, $size, $y, $color, 'center', imagesx($image) / 2);
    }

    private function drawText($image, string $text, ?string $font, int $size, int $y, int $color, string $align = 'left', int $x = 0): void
    {
        if ($font === null) {
            $textWidth = imagefontwidth(5) * strlen($text);
            $drawX = match ($align) {
                'center' => (int) ($x - $textWidth / 2),
                'right' => (int) ($x - $textWidth),
                default => $x,
            };
            imagestring($image, 5, $drawX, $y, $text, $color);

            return;
        }

        $box = imagettfbbox($size, 0, $font, $text);
        $textWidth = $box[2] - $box[0];
        $drawX = match ($align) {
            'center' => (int) ($x - $textWidth / 2),
            'right' => (int) ($x - $textWidth),
            default => $x,
        };

        imagettftext($image, $size, 0, $drawX, $y, $color, $font, $text);
    }

    private function wrapText(string $text, ?string $font, int $size, int $maxWidth): array
    {
        if ($font === null) {
            return [$text];
        }

        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $candidate = $currentLine === '' ? $word : $currentLine.' '.$word;
            $box = imagettfbbox($size, 0, $font, $candidate);
            $lineWidth = $box[2] - $box[0];

            if ($lineWidth > $maxWidth && $currentLine !== '') {
                $lines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $candidate;
            }
        }

        if ($currentLine !== '') {
            $lines[] = $currentLine;
        }

        return $lines;
    }

    private function resolveFontPath(): ?string
    {
        $candidates = [
            'C:\\Windows\\Fonts\\arial.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
            '/Library/Fonts/Arial.ttf',
            '/System/Library/Fonts/Helvetica.ttc',
        ];

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    private function resolveBoldFontPath(): ?string
    {
        $candidates = [
            'C:\\Windows\\Fonts\\arialbd.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
            '/Library/Fonts/Arial Bold.ttf',
            '/System/Library/Fonts/Helvetica.ttc',
        ];

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return $this->resolveFontPath();
    }

    private function resolveSignatureFontPath(): ?string
    {
        $candidates = [
            'C:\\Windows\\Fonts\\BRUSHSCI.TTF',
            '/usr/share/fonts/truetype/brush/BRUSHSCI.TTF',
            '/Library/Fonts/Brush Script MT.ttf',
        ];

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }
}
