@extends('layouts.app')

@section('title', $post->title . ' | EduSaaS PRO')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Article</li>
                </ol>
            </nav>

            <div class="card glass-card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h1 class="fw-bold text-dark mb-3">{{ $post->title }}</h1>
                    <div class="d-flex align-items-center text-muted small mb-4 pb-4 border-bottom">
                        <span class="me-3"><i class="bi bi-calendar3 me-1"></i> {{ $post->published_at->format('M d, Y') }}</span>
                        <span><i class="bi bi-folder2-open me-1"></i> {{ $post->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    
                    <div class="article-content lh-lg text-dark">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection