<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// Public routes
Route::get('/', [JobPostController::class, 'welcome'])->name('welcome');

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Routes that require authentication and employer role
Route::middleware(['auth', 'employer'])->group(function () {
    Route::get('job-posts/create', [JobPostController::class, 'create'])->name('job-posts.create');
    Route::post('job-posts', [JobPostController::class, 'store'])->name('job-posts.store');
    Route::get('job-posts/{jobPost}/edit', [JobPostController::class, 'edit'])->name('job-posts.edit');
    Route::put('job-posts/{jobPost}', [JobPostController::class, 'update'])->name('job-posts.update');
    Route::delete('job-posts/{jobPost}', [JobPostController::class, 'destroy'])->name('job-posts.destroy');
});

// Routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('job-posts/{jobPost}/apply', [ApplicationController::class, 'apply'])->name('job-posts.apply');
});

// Resource route for JobPostController
Route::resource('job-posts', JobPostController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

require __DIR__.'/auth.php';
