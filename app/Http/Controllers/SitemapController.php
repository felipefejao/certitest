<?php

namespace App\Http\Controllers;

use App\Actions\Seo\BuildSitemapAction;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(BuildSitemapAction $buildSitemap): Response
    {
        return response()
            ->view('seo.sitemap', ['urls' => $buildSitemap->handle()])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
