@extends('layouts.app')

@section('title', 'Admin Users | free-education.fun')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">User Management</h1>
            <form method="get" class="d-flex gap-2">
                <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Search name">
                <button type="submit" class="btn btn-primary">Search</button>
@section('title', 'Admin Users | EduSaaS PRO')

@section('content')
<div class="card glass-card shadow-sm border-0">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-1 fw-bold text-dark"><i class="bi bi-people-fill text-primary me-2"></i>User Management</h1>
                <p class="text-muted small mb-0">Manage platform access, roles, and SaaS subscription tiers.</p>
            </div>
            <form method="get" class="d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-start-0" name="q" value="{{ request('q') }}" placeholder="Search users...">
                    <button type="submit" class="btn btn-primary px-4">Search</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="border-0 rounded-start">User</th>
                    <th class="border-0">Role</th>
                    <th class="border-0">SaaS Tier</th>
                    <th class="border-0">Status</th>
                    <th class="border-0 text-end rounded-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_approved)
                                <span class="badge text-bg-success">Approved</span>
                            @else
                                <span class="badge text-bg-warning">Pending</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <form method="post" action="{{ route('admin.users.approve', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success" type="submit">Approve</button>
                                </form>
                                <form method="post" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                    <div class="small text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle text-capitalize">
                                <i class="bi bi-person-badge me-1"></i>{{ $user->role }}
                            </span>
                        </td>
                        <td>
                            @if($user->subscription_tier === 'premium')
                                <span class="badge bg-warning bg-opacity-25 text-dark border border-warning-subtle text-capitalize"><i class="bi bi-star-fill text-warning me-1"></i> Premium</span>
                            @elseif($user->subscription_tier === 'agency')
                                <span class="badge bg-purple bg-opacity-10 text-purple border border-purple-subtle text-capitalize" style="color: #6f42c1; border-color: #d63384;"><i class="bi bi-building me-1"></i> Agency</span>
                            @else
                                <span class="badge bg-light text-dark border text-capitalize"><i class="bi bi-box me-1"></i> Free</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_approved)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i>Approved</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle"><i class="bi bi-clock-history me-1"></i>Pending</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <form method="post" action="{{ route('admin.users.update', $user) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $user->name }}">
                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                    <input type="hidden" name="is_approved" value="1">
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                    <input type="hidden" name="subscription_tier" value="{{ $user->subscription_tier === 'free' ? 'premium' : 'free' }}">
                                    <button class="btn btn-sm {{ $user->subscription_tier === 'free' ? 'btn-outline-warning text-dark' : 'btn-outline-secondary' }}" type="submit" title="Toggle Premium">
                                        <i class="bi bi-star-fill"></i>
                                    </button>
                                </form>

                                @if(!$user->is_approved)
                                    <form method="post" action="{{ route('admin.users.approve', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-success" type="submit" title="Approve"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                @endif
                                <form method="post" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Permanently delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>
                    <tr><td colspan="5" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-2 d-block mb-2"></i>No users found matching your criteria.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>
</div>
@endsection
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
