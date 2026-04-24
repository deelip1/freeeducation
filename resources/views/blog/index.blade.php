@extends('layouts.app')

@section('title', 'Blog | free-education.fun')

@section('content')
@php
    $posts = \App\Models\BlogPost::query()->with('category')->where('approval_status','approved')->whereNotNull('published_at')->latest('published_at')->paginate(9);
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Latest Articles</h1>
    <a class="btn btn-outline-primary" href="{{ route('home') }}">Back to Home</a>
</div>

<div class="row g-3">
    @foreach($posts as $post)
        <div class="col-12 col-md-6 col-xl-4">
            <article class="card h-100 shadow-sm">
                <div class="card-body">
                    <span class="badge text-bg-secondary mb-2">{{ $post->category?->name ?? 'General' }}</span>
                    <h2 class="h5">{{ $post->title }}</h2>
                    <p class="text-muted small">{{ $post->excerpt }}</p>
                    <a href="{{ route('blog.show', ['category' => $post->category?->slug ?? 'general', 'slug' => $post->slug]) }}" class="btn btn-sm btn-primary">Read</a>
                </div>
            </article>
        </div>
    @endforeach
</div>

<div class="mt-3">{{ $posts->links() }}</div>
@endsection
@section('title', 'Educational Blog | EduSaaS PRO')

@section('content')
<div class="container py-4">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold text-dark mb-3"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i>Educational Resources</h1>
            <p class="text-muted lead">AI-curated learning materials, guides, and digital literacy updates.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($posts as $post)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card glass-card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle">
                                {{ $post->category->name ?? 'General' }}
                            </span>
                        </div>
                        <h5 class="card-title fw-bold text-dark">{{ $post->title }}</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ $post->published_at->format('M d, Y') }}</small>
                            <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-outline-primary stretched-link">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-file-earmark-x fs-1 text-muted d-block mb-3"></i>
                <h4 class="text-secondary">No published articles found.</h4>
                <p class="text-muted">Check back soon for new educational content.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
