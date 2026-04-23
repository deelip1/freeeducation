<?php

use App\Http\Controllers\Admin\ModuleController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('dashboard.index'))->name('home');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
});
