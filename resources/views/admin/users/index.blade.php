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
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>
</div>
@endsection
