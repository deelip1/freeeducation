@extends('layouts.app')

@section('title', 'Article | free-education.fun')

@section('content')
@php
    $post = \App\Models\BlogPost::query()->where('slug', request()->route('slug'))->firstOrFail();
@endphp

<div id="reading-progress" class="progress mb-3" role="progressbar" aria-label="Reading progress" aria-valuemin="0" aria-valuemax="100">
    <div id="reading-progress-bar" class="progress-bar" style="width: 0%"></div>
</div>

<article class="card shadow-sm">
    <div class="card-body">
        <h1>{{ $post->title }}</h1>
        <p class="text-muted">{{ optional($post->published_at)->format('d M Y') }}</p>
        <div>{!! nl2br(e($post->content)) !!}</div>
    </div>
</article>
@endsection

@section('scripts')
<script>
window.addEventListener('scroll', () => {
  const total = document.documentElement.scrollHeight - window.innerHeight;
  const pct = total > 0 ? (window.scrollY / total) * 100 : 0;
  document.getElementById('reading-progress-bar').style.width = pct + '%';
});
</script>
@endsection
