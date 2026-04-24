@extends('layouts.app')

@section('title', 'Home | free-education.fun')

@section('content')
<section class="p-4 p-lg-5 mb-4 rounded-4 text-white" style="background:linear-gradient(120deg,#0f172a,#1d4ed8,#0ea5e9)">
    <div class="row align-items-center g-3">
        <div class="col-lg-8">
            <h1 class="display-6 fw-bold">AI-Powered Content + Tools + Utility Platform</h1>
            <p class="lead mb-0">WordPress-like CMS, Canva-style creator, and smart ITR workflows in one secure SaaS.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="{{ route('blog.index') }}" class="btn btn-light me-2">Explore Blog</a>
            <a href="{{ route('itr.wizard') }}" class="btn btn-warning">Use ITR Tool</a>
        </div>
    </div>
</section>

@if(($featuredPosts ?? collect())->isNotEmpty())
<div id="featuredSlider" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner rounded-4 overflow-hidden">
        @foreach($featuredPosts as $post)
            <div class="carousel-item @if($loop->first) active @endif">
                <div class="d-block p-4 p-lg-5 bg-dark text-white" style="min-height: 240px;">
                    <span class="badge text-bg-info mb-2">Featured</span>
                    <h2 class="h3">{{ $post->title }}</h2>
                    <p class="opacity-75">{{ $post->excerpt }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="row g-3">
    @foreach(($categorySections ?? collect()) as $category)
        <div class="col-12 col-lg-6">
            <div class="card glass-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>{{ $category->name }}</strong>
                    <small class="text-muted">{{ $category->posts->count() }} posts</small>
                </div>
                <div class="card-body">
                    @forelse($category->posts as $post)
                        <div class="pb-2 mb-2 border-bottom">
                            <h3 class="h6 mb-1">{{ $post->title }}</h3>
                            <small class="text-muted">{{ optional($post->published_at)->format('d M Y') }}</small>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No published posts yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
