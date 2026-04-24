<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredPosts = BlogPost::query()
            ->where('approval_status', 'approved')
            ->whereNotNull('published_at')
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(5)
            ->get();

        $categorySections = BlogCategory::query()
            ->where('is_active', true)
            ->with(['posts' => fn ($q) => $q->where('approval_status', 'approved')->whereNotNull('published_at')->latest('published_at')->take(4)])
            ->take(6)
            ->get();

        return view('dashboard.index', compact('featuredPosts', 'categorySections'));
    }
}
