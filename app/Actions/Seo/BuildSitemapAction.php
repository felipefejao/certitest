<?php

namespace App\Actions\Seo;

class BuildSitemapAction
{
    /**
     * @return array<int, string>
     */
    public function handle(): array
    {
        return [
            route('home'),
            route('privacy'),
        ];
    }
}
