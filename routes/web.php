<?php

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
Route::view('/blog/{slug}', 'blog.show')->name('blog.show');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('seo.sitemap');

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
