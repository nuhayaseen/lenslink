<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LensLink – Photography Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:      #1a1a2e;
            --accent:       #c9a84c;
            --accent-light: #f0d080;
            --soft:         #f7f4ef;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: var(--primary);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: var(--primary);
            padding: 16px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--accent) !important;
        }

        .navbar-brand span { color: #fff; }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-size: 14px;
            font-weight: 500;
            padding: 6px 16px !important;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .nav-link:hover { color: var(--accent) !important; }

        .btn-nav-login {
            border: 1px solid rgba(201,168,76,0.5);
            color: var(--accent) !important;
            padding: 7px 20px;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-nav-login:hover { background: rgba(201,168,76,0.1); }

        .btn-nav-signup {
            background: var(--accent);
            color: var(--primary) !important;
            font-weight: 700;
            padding: 7px 20px;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            border: none;
        }

        .btn-nav-signup:hover { background: var(--accent-light); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            background:
                linear-gradient(135deg, rgba(26,26,46,0.92) 0%, rgba(26,26,46,0.75) 100%),
                url('https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=1600&q=80')
                center/cover no-repeat;
            display: flex;
            align-items: center;
            padding-top: 80px;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(201,168,76,0.2);
            border: 1px solid rgba(201,168,76,0.4);
            color: var(--accent);
            font-size: 13px;
            font-weight: 500;
            padding: 6px 18px;
            border-radius: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 24px;
        }

        .hero h1 {
            font-size: clamp(42px, 6vw, 72px);
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 24px;
        }

        .hero h1 span { color: var(--accent); }

        .hero p {
            font-size: 18px;
            color: rgba(255,255,255,0.75);
            max-width: 520px;
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .btn-hero-primary {
            background: var(--accent);
            color: var(--primary);
            font-weight: 700;
            font-size: 16px;
            padding: 14px 36px;
            border-radius: 10px;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-hero-primary:hover {
            background: var(--accent-light);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .btn-hero-secondary {
            background: transparent;
            color: #fff;
            font-weight: 500;
            font-size: 16px;
            padding: 14px 36px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-color: rgba(255,255,255,0.6);
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.15);
        }

        .hero-stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--accent);
        }

        .hero-stat-label {
            font-size: 13px;
            color: rgba(255,255,255,0.6);
            margin-top: 2px;
        }

        /* ── HOW IT WORKS ── */
        .section-tag {
            display: inline-block;
            background: rgba(201,168,76,0.12);
            color: var(--accent);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 18px;
            border-radius: 20px;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 16px;
        }

        .section-sub {
            font-size: 16px;
            color: #6c757d;
            max-width: 500px;
            margin: 0 auto 60px;
            line-height: 1.7;
        }

        .step-card {
            text-align: center;
            padding: 40px 30px;
            border-radius: 20px;
            background: var(--soft);
            transition: all 0.3s;
            height: 100%;
        }

        .step-card:hover {
            background: var(--primary);
            transform: translateY(-6px);
        }

        .step-card:hover .step-title,
        .step-card:hover .step-desc { color: #fff; }

        .step-card:hover .step-num { background: var(--accent); color: var(--primary); }

        .step-num {
            width: 56px;
            height: 56px;
            background: var(--primary);
            color: var(--accent);
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            transition: all 0.3s;
        }

        .step-icon {
            font-size: 36px;
            margin-bottom: 16px;
            display: block;
        }

        .step-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--primary);
            transition: color 0.3s;
            font-family: 'Playfair Display', serif;
        }

        .step-desc {
            font-size: 14px;
            color: #6c757d;
            line-height: 1.7;
            transition: color 0.3s;
        }

        /* ── FEATURES ── */
        .features-section {
            background: var(--primary);
            padding: 100px 0;
        }

        .feature-item {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            background: rgba(201,168,76,0.15);
            border: 1px solid rgba(201,168,76,0.3);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--accent);
            flex-shrink: 0;
        }

        .feature-title {
            font-size: 17px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 6px;
            font-family: 'Playfair Display', serif;
        }

        .feature-desc {
            font-size: 14px;
            color: rgba(255,255,255,0.55);
            line-height: 1.6;
        }

        .feature-image-box {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            overflow: hidden;
            height: 100%;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .feature-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 24px;
            opacity: 0.85;
        }

        /* ── PHOTOGRAPHER CARDS ── */
        .phot-section { padding: 100px 0; background: var(--soft); }

        .phot-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            transition: all 0.3s;
        }

        .phot-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(0,0,0,0.12);
        }

        .phot-card-img {
            height: 200px;
            background: linear-gradient(135deg, var(--primary), #4a4e69);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 56px;
            font-weight: 700;
            color: var(--accent);
        }

        .phot-card-body { padding: 24px; }

        .phot-name {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 4px;
        }

        .phot-meta {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 12px;
        }

        .phot-tag {
            display: inline-block;
            background: var(--soft);
            color: var(--primary);
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            margin-right: 4px;
            margin-bottom: 4px;
        }

        .phot-price {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
        }

        .phot-rating {
            font-size: 13px;
            color: var(--accent);
            font-weight: 600;
        }

        /* ── ROLES SECTION ── */
        .roles-section { padding: 100px 0; }

        .role-card {
            border-radius: 24px;
            padding: 48px 40px;
            height: 100%;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }

        .role-card-dark {
            background: var(--primary);
            color: #fff;
        }

        .role-card-gold {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: var(--primary);
        }

        .role-emoji { font-size: 52px; margin-bottom: 20px; display: block; }

        .role-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .role-desc {
            font-size: 15px;
            line-height: 1.7;
            opacity: 0.8;
            margin-bottom: 28px;
        }

        .role-list {
            list-style: none;
            padding: 0;
            margin-bottom: 36px;
        }

        .role-list li {
            font-size: 14px;
            padding: 6px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0.9;
        }

        .role-list li i { color: var(--accent); font-size: 16px; }
        .role-card-gold .role-list li i { color: var(--primary); }

        .btn-role-dark {
            background: var(--accent);
            color: var(--primary);
            font-weight: 700;
            padding: 12px 32px;
            border-radius: 10px;
            border: none;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-role-dark:hover {
            background: var(--accent-light);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .btn-role-gold {
            background: var(--primary);
            color: #fff;
            font-weight: 700;
            padding: 12px 32px;
            border-radius: 10px;
            border: none;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-role-gold:hover {
            background: #2d2d4e;
            color: #fff;
            transform: translateY(-2px);
        }

        /* ── CTA ── */
        .cta-section {
            background:
                linear-gradient(135deg, rgba(26,26,46,0.95) 0%, rgba(26,26,46,0.85) 100%),
                url('https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=1600&q=80')
                center/cover no-repeat;
            padding: 120px 0;
            text-align: center;
        }

        .cta-section h2 {
            font-size: clamp(32px, 5vw, 56px);
            color: #fff;
            margin-bottom: 20px;
        }

        .cta-section h2 span { color: var(--accent); }

        .cta-section p {
            font-size: 18px;
            color: rgba(255,255,255,0.7);
            margin-bottom: 40px;
        }

        /* ── FOOTER ── */
        .footer {
            background: var(--primary);
            padding: 60px 0 30px;
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .footer-brand span { color: #fff; }

        .footer-desc {
            font-size: 14px;
            color: rgba(255,255,255,0.5);
            line-height: 1.7;
            max-width: 280px;
        }

        .footer-title {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 20px;
        }

        .footer-link {
            display: block;
            font-size: 14px;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            margin-bottom: 10px;
            transition: color 0.2s;
        }

        .footer-link:hover { color: var(--accent); }

        .footer-divider {
            border-color: rgba(255,255,255,0.1);
            margin: 40px 0 24px;
        }

        .footer-bottom {
            font-size: 13px;
            color: rgba(255,255,255,0.35);
            text-align: center;
        }

        .footer-bottom span { color: var(--accent); }

        /* ── SCROLL ANIMATION ── */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-camera2 me-2"></i>Lens<span>Link</span>
        </a>
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#nav">
            <i class="bi bi-list text-white fs-3"></i>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto ms-4">
                <li class="nav-item">
                    <a class="nav-link" href="#how-it-works">How it works</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('photographers.index') }}">
                        Browse
                    </a>
                </li>
            </ul>
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('login') }}" class="nav-link btn-nav-login">Login</a>
                <a href="{{ route('register') }}" class="btn-nav-signup">Get Started</a>
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="bi bi-star-fill me-2"></i>
                    Sri Lanka's Photography Marketplace
                </div>
                <h1>
                    Find Your Perfect
                    <span>Photographer</span>
                    For Every Moment
                </h1>
                <p>
                    Connect with talented photographers across Sri Lanka.
                    Browse portfolios, compare packages, and book with confidence
                    — all in one place.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('photographers.index') }}" class="btn-hero-primary">
                        <i class="bi bi-search me-2"></i> Browse Photographers
                    </a>
                    <a href="{{ route('register') }}" class="btn-hero-secondary">
                        <i class="bi bi-camera2 me-2"></i> Join as Photographer
                    </a>
                </div>

                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-num">500+</div>
                        <div class="hero-stat-label">Happy Clients</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">120+</div>
                        <div class="hero-stat-label">Photographers</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">1,200+</div>
                        <div class="hero-stat-label">Bookings Done</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">4.9★</div>
                        <div class="hero-stat-label">Avg Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="py-5" id="how-it-works" style="padding: 100px 0 !important; background:#fff">
    <div class="container">
        <div class="text-center fade-up">
            <div class="section-tag">Simple Process</div>
            <h2 class="section-title">How LensLink Works</h2>
            <p class="section-sub">
                Book your perfect photographer in just a few simple steps
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-3 fade-up">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <span class="step-icon">🔍</span>
                    <div class="step-title">Browse Photographers</div>
                    <p class="step-desc">
                        Search by location, specialization and price. View portfolios and reviews.
                    </p>
                </div>
            </div>
            <div class="col-md-3 fade-up">
                <div class="step-card">
                    <div class="step-num">2</div>
                    <span class="step-icon">📦</span>
                    <div class="step-title">Choose a Package</div>
                    <p class="step-desc">
                        Select from Basic, Standard or Premium packages that fit your budget.
                    </p>
                </div>
            </div>
            <div class="col-md-3 fade-up">
                <div class="step-card">
                    <div class="step-num">3</div>
                    <span class="step-icon">📅</span>
                    <div class="step-title">Send Request</div>
                    <p class="step-desc">
                        Submit your booking request with event details. Photographer responds within 24hrs.
                    </p>
                </div>
            </div>
            <div class="col-md-3 fade-up">
                <div class="step-card">
                    <div class="step-num">4</div>
                    <span class="step-icon">📸</span>
                    <div class="step-title">Capture Memories</div>
                    <p class="step-desc">
                        Enjoy your event and receive beautifully edited photos delivered to you.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features-section" id="features">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-up">
                <div class="section-tag">Why Choose Us</div>
                <h2 class="section-title" style="color:#fff">
                    Everything You Need in One Platform
                </h2>
                <p style="color:rgba(255,255,255,0.6);font-size:15px;margin-bottom:40px;line-height:1.8">
                    LensLink brings together the best photographers and clients
                    with powerful tools to make every booking seamless.
                </p>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <div class="feature-title">Verified Photographers</div>
                        <p class="feature-desc">
                            Every photographer is verified with real portfolios and authentic client reviews.
                        </p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <div class="feature-title">Smart Booking System</div>
                        <p class="feature-desc">
                            Automatic conflict prevention ensures no double bookings. Real-time availability.
                        </p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-box"></i>
                    </div>
                    <div>
                        <div class="feature-title">Flexible Packages</div>
                        <p class="feature-desc">
                            Photographers offer Basic, Standard and Premium packages to fit every budget.
                        </p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-star"></i>
                    </div>
                    <div>
                        <div class="feature-title">Trusted Reviews</div>
                        <p class="feature-desc">
                            Only clients who completed a booking can leave reviews — guaranteed authenticity.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 fade-up">
                <div class="feature-image-box">
                    <img src="https://images.unsplash.com/photo-1542038784456-1ea8e935640e?w=800&q=80"
                         alt="Photography">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SAMPLE PHOTOGRAPHERS -->
<section class="phot-section">
    <div class="container">
        <div class="text-center fade-up mb-5">
            <div class="section-tag">Our Talent</div>
            <h2 class="section-title">Featured Photographers</h2>
            <p class="section-sub">
                Discover talented photographers ready to capture your special moments
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4 fade-up">
                <div class="phot-card">
                    <div class="phot-card-img">A</div>
                    <div class="phot-card-body">
                        <div class="phot-name">Amara Silva</div>
                        <div class="phot-meta">
                            <i class="bi bi-geo-alt me-1"></i>Kandy ·
                            <i class="bi bi-award me-1 ms-1"></i>8 yrs exp
                        </div>
                        <div class="mb-3">
                            <span class="phot-tag">Wedding</span>
                            <span class="phot-tag">Portrait</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="phot-price">LKR 8,000</div>
                                <small class="text-muted">per hour</small>
                            </div>
                            <div class="phot-rating">
                                <i class="bi bi-star-fill me-1"></i>4.9
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 fade-up">
                <div class="phot-card">
                    <div class="phot-card-img">R</div>
                    <div class="phot-card-body">
                        <div class="phot-name">Rajan Perera</div>
                        <div class="phot-meta">
                            <i class="bi bi-geo-alt me-1"></i>Colombo ·
                            <i class="bi bi-award me-1 ms-1"></i>5 yrs exp
                        </div>
                        <div class="mb-3">
                            <span class="phot-tag">Corporate</span>
                            <span class="phot-tag">Events</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="phot-price">LKR 12,000</div>
                                <small class="text-muted">per hour</small>
                            </div>
                            <div class="phot-rating">
                                <i class="bi bi-star-fill me-1"></i>4.7
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 fade-up">
                <div class="phot-card">
                    <div class="phot-card-img">N</div>
                    <div class="phot-card-body">
                        <div class="phot-name">Nisha Fernando</div>
                        <div class="phot-meta">
                            <i class="bi bi-geo-alt me-1"></i>Galle ·
                            <i class="bi bi-award me-1 ms-1"></i>3 yrs exp
                        </div>
                        <div class="mb-3">
                            <span class="phot-tag">Fashion</span>
                            <span class="phot-tag">Baby</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="phot-price">LKR 6,500</div>
                                <small class="text-muted">per hour</small>
                            </div>
                            <div class="phot-rating">
                                <i class="bi bi-star-fill me-1"></i>4.9
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5 fade-up">
            <a href="{{ route('photographers.index') }}" class="btn-hero-primary">
                <i class="bi bi-grid me-2"></i> View All Photographers
            </a>
        </div>
    </div>
</section>

<!-- JOIN AS CLIENT OR PHOTOGRAPHER -->
<section class="roles-section">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <div class="section-tag">Join LensLink</div>
            <h2 class="section-title">Choose Your Role</h2>
            <p class="section-sub">
                Whether you need a photographer or you are one — LensLink is built for you
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 fade-up">
                <div class="role-card role-card-dark">
                    <span class="role-emoji">🧑‍💼</span>
                    <h3 class="role-title" style="color:#fff">I'm a Client</h3>
                    <p class="role-desc" style="color:rgba(255,255,255,0.65)">
                        Find and book the perfect photographer for your wedding,
                        birthday, corporate event or any special occasion.
                    </p>
                    <ul class="role-list">
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span style="color:rgba(255,255,255,0.8)">Browse verified photographer profiles</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span style="color:rgba(255,255,255,0.8)">View portfolios and read reviews</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span style="color:rgba(255,255,255,0.8)">Choose from flexible packages</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span style="color:rgba(255,255,255,0.8)">Track bookings in real-time</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span style="color:rgba(255,255,255,0.8)">Leave reviews after your event</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-role-dark">
                        <i class="bi bi-person-plus me-2"></i> Register as Client
                    </a>
                </div>
            </div>

            <div class="col-md-6 fade-up">
                <div class="role-card role-card-gold">
                    <span class="role-emoji">📷</span>
                    <h3 class="role-title">I'm a Photographer</h3>
                    <p class="role-desc">
                        Grow your photography business by connecting with clients
                        across Sri Lanka. Manage bookings effortlessly.
                    </p>
                    <ul class="role-list">
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Create a stunning portfolio</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Set your own packages and pricing</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Accept or decline booking requests</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Track earnings and bookings</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Build your reputation with reviews</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-role-gold">
                        <i class="bi bi-camera2 me-2"></i> Register as Photographer
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container fade-up">
        <h2>
            Ready to Capture Your
            <span>Perfect Moment?</span>
        </h2>
        <p>
            Join thousands of clients and photographers already using LensLink
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('photographers.index') }}" class="btn-hero-primary">
                <i class="bi bi-search me-2"></i> Browse Photographers
            </a>
            <a href="{{ route('register') }}" class="btn-hero-secondary">
                <i class="bi bi-person-plus me-2"></i> Create Free Account
            </a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="footer-brand">
                    <i class="bi bi-camera2 me-2"></i>Lens<span>Link</span>
                </div>
                <p class="footer-desc">
                    Sri Lanka's premier photography marketplace connecting talented
                    photographers with clients for every occasion.
                </p>
            </div>
            <div class="col-md-2 offset-md-1">
                <div class="footer-title">Platform</div>
                <a href="{{ route('photographers.index') }}" class="footer-link">Browse Photographers</a>
                <a href="{{ route('register') }}" class="footer-link">Join as Client</a>
                <a href="{{ route('register') }}" class="footer-link">Join as Photographer</a>
                <a href="{{ route('login') }}" class="footer-link">Login</a>
            </div>
            <div class="col-md-2">
                <div class="footer-title">Services</div>
                <a href="#" class="footer-link">Wedding Photography</a>
                <a href="#" class="footer-link">Corporate Events</a>
                <a href="#" class="footer-link">Portrait Sessions</a>
                <a href="#" class="footer-link">Fashion Shoots</a>
            </div>
            <div class="col-md-3">
                <div class="footer-title">Contact</div>
                <a href="#" class="footer-link">
                    <i class="bi bi-envelope me-2"></i>info@lenslink.lk
                </a>
                <a href="#" class="footer-link">
                    <i class="bi bi-telephone me-2"></i>+94 77 123 4567
                </a>
                <a href="#" class="footer-link">
                    <i class="bi bi-geo-alt me-2"></i>Kandy, Sri Lanka
                </a>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">
            © {{ date('Y') }} <span>LensLink</span> — Photography Marketplace.
            All rights reserved. Built with ❤️ in Sri Lanka.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Scroll fade animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
</script>
</body>
</html>