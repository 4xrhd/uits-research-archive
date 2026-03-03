<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/archive', [HomeController::class, 'archive'])->name('archive');
Route::get('/archive/{id}', [HomeController::class, 'show'])->name('archive.show');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Authentication Routes (Laravel Breeze provides these)
require __DIR__.'/auth.php';

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Submission Routes
    Route::get('/submissions/create', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{id}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::get('/submissions/{id}/edit', [SubmissionController::class, 'edit'])->name('submissions.edit');
    Route::put('/submissions/{id}', [SubmissionController::class, 'update'])->name('submissions.update');
    Route::delete('/submissions/{id}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');
    
    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/submissions', [AdminController::class, 'submissions'])->name('submissions');
        Route::post('/submissions/{id}/review', [AdminController::class, 'review'])->name('submissions.review');
        Route::get('/submissions/{id}/edit', [AdminController::class, 'editSubmission'])->name('submissions.edit');
        Route::put('/submissions/{id}', [AdminController::class, 'updateSubmission'])->name('submissions.update');
        Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
        
        // User Management Routes
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{id}/role', [AdminController::class, 'toggleUserRole'])->name('users.role');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    });
});
