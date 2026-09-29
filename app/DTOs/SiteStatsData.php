<?php

namespace App\DTOs;

readonly class SiteStatsData
{
    public function __construct(
        public int $exams,
        public int $questions,
        public int $attempts,
    ) {}
}
