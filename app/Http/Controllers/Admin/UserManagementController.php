<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->string('q')->isNotEmpty(), fn ($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'is_approved' => ['boolean'],
            // ✅ HIGHLIGHT: Allow setting role and tier on creation.
            'role' => ['nullable', 'in:admin,moderator,educator,student,user'],
            'subscription_tier' => ['nullable', 'in:free,premium,agency'],
        ]);

        User::query()->create($validated);

        return back()->with('status', 'User created successfully.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        // ✅ HIGHLIGHT: Added strict validation for SaaS tier and role management.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'is_approved' => ['boolean'],
            'role' => ['required', 'in:admin,moderator,educator,student,user'],
            'subscription_tier' => ['required', 'in:free,premium,agency'],
        ]);

        $user->update($validated);

        return back()->with('status', 'User updated successfully.');
        return back()->with('status', 'User access and subscription updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('status', 'User deleted successfully.');
    }

    public function approve(User $user): RedirectResponse
    {
        $user->update(['is_approved' => true]);

        return back()->with('status', 'User approved.');
    }
}
}
