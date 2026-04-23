@extends('layouts.app')

@section('title', 'Dashboard | free-education.fun')

@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-8">
        <div class="card glass-card shadow-sm h-100">
            <div class="card-body">
                <h1 class="h3">Advanced AI Education SaaS</h1>
                <p class="text-secondary mb-3">Bilingual content, dynamic modules, vacancy and government update workflows with secure admin approvals.</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge text-bg-primary">Laravel</span>
                    <span class="badge text-bg-success">MySQL</span>
                    <span class="badge text-bg-warning">Redis Queue</span>
                    <span class="badge text-bg-info">Bootstrap 5.3</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card glass-card shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5">Quick Links</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-transparent px-0"><a href="{{ route('itr.wizard') }}">ITR AI Wizard</a></li>
                    <li class="list-group-item bg-transparent px-0"><a href="{{ route('admin.users.index') }}">Admin Users</a></li>
                    <li class="list-group-item bg-transparent px-0"><a href="{{ route('admin.modules.index') }}">Dynamic Modules</a></li>
                    <li class="list-group-item bg-transparent px-0"><a href="{{ route('seo.sitemap') }}">Sitemap XML</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
