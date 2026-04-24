@extends('layouts.app')

@section('title', 'Blog | free-education.fun')

@section('content')
@php
    $posts = \App\Models\BlogPost::query()->where('approval_status','approved')->whereNotNull('published_at')->latest('published_at')->paginate(9);
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
                    <h2 class="h5">{{ $post->title }}</h2>
                    <p class="text-muted small">{{ $post->excerpt }}</p>
                    <a href="{{ route('blog.show', ['slug' => $post->slug]) }}" class="btn btn-sm btn-primary">Read</a>
                </div>
            </article>
        </div>
    @endforeach
</div>

<div class="mt-3">{{ $posts->links() }}</div>
@endsection
