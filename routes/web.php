<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\Employer;

// Public routes
Route::get('/', [JobPostController::class, 'welcome'])->name('welcome');

// Route untuk dashboard (sesuaikan berdasarkan role)
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'employer') {
        return redirect()->route('employer.dashboard');
    }
    return redirect()->route('welcome');
})->middleware(['auth'])->name('dashboard');

// Routes untuk employer
Route::middleware(['auth', \App\Http\Middleware\Employer::class])->group(function () {
    Route::get('/employer/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
    Route::get('/employer/applications', [EmployerController::class, 'applications'])->name('employer.applications');
    
    // Tambahkan route untuk update status aplikasi
    Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])
        ->name('applications.update-status');
    
    // Job post routes
    Route::get('job-posts/create', [JobPostController::class, 'create'])->name('job-posts.create');
    Route::post('job-posts', [JobPostController::class, 'store'])->name('job-posts.store');
    Route::get('job-posts/{jobPost}/edit', [JobPostController::class, 'edit'])->name('job-posts.edit');
    Route::put('job-posts/{jobPost}', [JobPostController::class, 'update'])->name('job-posts.update');
    Route::delete('job-posts/{jobPost}', [JobPostController::class, 'destroy'])->name('job-posts.destroy');
    Route::get('/applications/{application}/cv', [ApplicationController::class, 'viewCV'])->name('applications.view-cv');
});

// Routes untuk job seeker
Route::middleware(['auth'])->group(function () {
    Route::get('/my-applications', [ApplicationController::class, 'index'])->name('user.applications');
    Route::post('/job-posts/{jobPost}/apply', [ApplicationController::class, 'apply'])->name('job-posts.apply');
});

// Routes that require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Resource route for JobPostController
Route::resource('job-posts', JobPostController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

// Admin routes
Route::middleware(['auth', \App\Http\Middleware\Admin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // User Management
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    
    // Job Posts Management
    Route::get('/admin/job-posts', [AdminController::class, 'jobPosts'])->name('admin.job-posts.index');
    Route::get('/admin/job-posts/{jobPost}/edit', [AdminController::class, 'editJobPost'])->name('admin.job-posts.edit');
    Route::put('/admin/job-posts/{jobPost}', [AdminController::class, 'updateJobPost'])->name('admin.job-posts.update');
    Route::delete('/admin/job-posts/{jobPost}', [AdminController::class, 'destroyJobPost'])->name('admin.job-posts.destroy');
});

// Add this route middleware
Route::get('/job-posts/{jobPost}', [JobPostController::class, 'show'])
    ->name('job-posts.show')
    ->middleware('auth');

Route::get('/job-posts', [JobPostController::class, 'index'])
    ->name('job-posts.index')
    ->middleware('auth');

require __DIR__.'/auth.php';
