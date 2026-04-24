<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $items = BlogPost::query()->whereNotNull('published_at')->latest('published_at')->limit(1000)->get(['slug', 'updated_at']);

        $xml = view('partials.sitemap', compact('items'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
