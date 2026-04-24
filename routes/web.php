<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\Tax\TaxRuleController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Api\SitemapController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/itr/wizard', 'dashboard.itr.wizard')->name('itr.wizard');
Route::view('/blog', 'blog.index')->name('blog.index');
Route::view('/blog/editor', 'blog.editor')->name('blog.editor');
Route::view('/blog/{category}/{slug}', 'blog.show')->name('blog.show');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('seo.sitemap');

use App\Models\BlogPost; // ✅ HIGHLIGHT: Imported the BlogPost model.
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('dashboard.index'))->name('home');
Route::get('/itr/wizard', fn () => view('dashboard.itr.wizard'))->name('itr.wizard');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('seo.sitemap');

// ✅ HIGHLIGHT: Registered missing blog routes to fix the exception.
Route::get('/blog', function () {
    $posts = BlogPost::query()
        ->where('approval_status', 'approved')
        ->whereNotNull('published_at')
        ->latest('published_at')
        ->paginate(12);

    return view('blog.index', compact('posts'));
})->name('blog.index');

Route::get('/blog/{slug}', function (string $slug) {
    $post = BlogPost::query()
        ->where('slug', $slug)
        ->where('approval_status', 'approved')
        ->firstOrFail();

    return view('blog.show', compact('post'));
})->name('blog.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function (): void {
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');

    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/approve', [UserManagementController::class, 'approve'])->name('users.approve');

    Route::get('/tax-rules', [TaxRuleController::class, 'index'])->name('tax-rules.index');
    Route::post('/tax-rules', [TaxRuleController::class, 'store'])->name('tax-rules.store');
});
/*
|--------------------------------------------------------------------------
| Admin SaaS Management Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        
        // Dynamic Modules
        Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
        Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');

        // User & Subscription Management
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{user}/approve', [UserManagementController::class, 'approve'])->name('users.approve');

        // Tax Rules Management
        Route::get('/tax-rules', [TaxRuleController::class, 'index'])->name('tax-rules.index');
        Route::post('/tax-rules', [TaxRuleController::class, 'store'])->name('tax-rules.store');
    });
