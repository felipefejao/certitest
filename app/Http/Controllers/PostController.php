<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\LocaleUrls;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::published()
            ->orderByDesc('published_at')
            ->get(['id', 'title', 'slug', 'excerpt', 'published_at']);

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => __('ui.blog.title').' — '.config('app.name'),
            'url' => LocaleUrls::url('blog.index'),
            'inLanguage' => str_replace('_', '-', app()->getLocale()),
        ];

        return view('blog.index', [
            'posts' => $posts,
            'jsonLd' => $jsonLd,
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        $metaDescription = $post->meta_description
            ?? $post->excerpt
            ?? Str::limit(strip_tags(Str::markdown($post->body)), 160);

        $breadcrumbs = [
            ['name' => config('app.name'), 'url' => LocaleUrls::url('home')],
            ['name' => __('ui.blog.title'), 'url' => LocaleUrls::url('blog.index')],
            ['name' => $post->title, 'url' => LocaleUrls::url('blog.show', ['slug' => $post->slug])],
        ];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Article',
                    'headline' => $post->title,
                    'description' => $metaDescription,
                    'url' => LocaleUrls::url('blog.show', ['slug' => $post->slug]),
                    'inLanguage' => str_replace('_', '-', app()->getLocale()),
                    'datePublished' => $post->published_at?->toAtomString(),
                    'dateModified' => $post->updated_at->toAtomString(),
                    'author' => [
                        '@type' => 'Organization',
                        'name' => config('app.name'),
                        'url' => LocaleUrls::url('home'),
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => array_map(
                        fn (array $item, int $position): array => [
                            '@type' => 'ListItem',
                            'position' => $position + 1,
                            'name' => $item['name'],
                            'item' => $item['url'],
                        ],
                        $breadcrumbs,
                        array_keys($breadcrumbs),
                    ),
                ],
            ],
        ];

        return view('blog.show', [
            'post' => $post,
            'metaTitle' => $post->meta_title,
            'metaDescription' => $metaDescription,
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $jsonLd,
        ]);
    }
}
