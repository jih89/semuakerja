<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'JobSeeker') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        .hero-section {
            position: relative;
            height: 600px;
            overflow: hidden;
        }
        .hero-image {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        .hero-content {
            position: relative;
            z-index: 1;
            height: 100%;
        }
        .job-card {
            transition: all 0.3s ease;
        }
        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">SemuaKerja</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                @if (Route::has('login'))
                    <ul class="navbar-nav">
                        @auth
                            <!-- User Dropdown When Logged In -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="bi bi-person me-2"></i>Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary ms-2">Register</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902" alt="Hero image" class="hero-image">
        <div class="hero-overlay"></div>
        <div class="hero-content d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="display-4 text-white fw-bold mb-3">Find Your Dream Job</h1>
                        <p class="lead text-white-50 mb-4">Connect with thousands of employers and discover opportunities that match your skills and aspirations.</p>
                        <div class="d-grid gap-2 d-md-flex">
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">Get Started</a>
                            <a href="#featured-jobs" class="btn btn-outline-light btn-lg px-4">View Jobs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Listings Section -->
    <section class="py-5 bg-light" id="featured-jobs">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Latest Job Opportunities</h2>
                <p class="lead text-muted">Discover your next career move</p>
            </div>

            <div class="row g-4">
                @forelse ($jobPosts as $job)
                    <div class="col-md-6 col-lg-4">
                        <div class="card job-card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('job-posts.show', $job) }}" class="text-decoration-none text-dark">
                                        {{ $job->title }}
                                    </a>
                                </h5>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt me-2"></i>{{ $job->location }}
                                    </small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-briefcase me-2"></i>{{ ucfirst($job->jobType) }}
                                    </small>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="bi bi-currency-dollar me-2"></i>${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                    </small>
                                </div>
                                <p class="card-text text-muted small">{{ Str::limit($job->description, 150) }}</p>
                                <a href="{{ route('job-posts.show', $job) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No job posts available at the moment.</p>
                    </div>
                @endforelse
            </div>

            @if($jobPosts->count() > 0)
                <div class="text-center mt-5">
                    <a href="{{ route('job-posts.index') }}" class="btn btn-primary btn-lg">View All Jobs</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase">Features</span>
                <h2 class="display-5 fw-bold mt-2">Everything you need to find your next job</h2>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-briefcase fs-4"></i>
                        </div>
                        <h3 class="h5">Latest Job Postings</h3>
                        <p class="text-muted">Access the most recent job opportunities from top companies.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-graph-up fs-4"></i>
                        </div>
                        <h3 class="h5">Salary Insights</h3>
                        <p class="text-muted">Compare salaries and benefits across different positions.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-lightning fs-4"></i>
                        </div>
                        <h3 class="h5">Quick Apply</h3>
                        <p class="text-muted">Apply to multiple jobs with just a few clicks.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} JobSeeker. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
