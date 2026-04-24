@extends('layouts.app')

@section('title', 'ITR AI Wizard | free-education.fun')

@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm glass-card">
            <div class="card-body">
                <h1 class="h4">AI-Based ITR Filing Wizard (India)</h1>
                <p class="text-secondary">Step-wise, bilingual, secure and approval-ready tax filing workflow.</p>

                <ol class="list-group list-group-numbered mb-3">
                    <li class="list-group-item">Create PAN profile + optional Aadhaar link (encrypted)</li>
                    <li class="list-group-item">Enter income, deductions, and tax credits</li>
                    <li class="list-group-item">Compare Old vs New regime automatically</li>
                    <li class="list-group-item">Get ITR form suggestion (ITR-1/2/3/4)</li>
                    <li class="list-group-item">Generate computation sheet + ITR JSON draft</li>
                </ol>

                <div class="alert alert-info mb-0">
                    API endpoints: <code>POST /api/itr/profile</code>, <code>POST /api/itr/compute</code>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h6">Security & Compliance</h2>
                <ul class="small mb-0">
                    <li>PAN/Aadhaar validation</li>
                    <li>Aadhaar encryption at rest</li>
                    <li>Auth + throttled APIs</li>
                    <li>Admin rule overrides via Tax Rules module</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
