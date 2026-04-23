<?php

use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\Tax\TaxRuleController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Api\SitemapController;
use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('dashboard.index'))->name('home');
Route::get('/itr/wizard', fn () => view('dashboard.itr.wizard'))->name('itr.wizard');
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

    // ✅ UPDATED: Admin-managed tax rules for AY/regime updates.
    Route::get('/tax-rules', [TaxRuleController::class, 'index'])->name('tax-rules.index');
    Route::post('/tax-rules', [TaxRuleController::class, 'store'])->name('tax-rules.store');
});
