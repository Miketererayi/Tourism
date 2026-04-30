<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Primary -->
    <title>{{ $seo['title'] ?? ($currentCountry->name . ' Directory') }}</title>
    <meta name="description" content="{{ $seo['description'] ?? ('Find the best places and services in ' . $currentCountry->name) }}">
    
    @if(!empty($seo['canonical']))
        <link rel="canonical" href="{{ $seo['canonical'] }}">
    @endif

    @if(!empty($seo['robots']))
        <meta name="robots" content="{{ $seo['robots'] }}">
    @else
        <meta name="robots" content="index, follow">
    @endif

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $seo['og_title'] ?? ($seo['title'] ?? '') }}">
    <meta property="og:description" content="{{ $seo['og_description'] ?? ($seo['description'] ?? '') }}">
    <meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}">
    @if(!empty($seo['canonical']))
        <meta property="og:url" content="{{ $seo['canonical'] }}">
    @endif
    @if(!empty($seo['og_image']))
        <meta property="og:image" content="{{ $seo['og_image'] }}">
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['og_title'] ?? ($seo['title'] ?? '') }}">
    <meta name="twitter:description" content="{{ $seo['og_description'] ?? ($seo['description'] ?? '') }}">
    @if(!empty($seo['og_image']))
        <meta name="twitter:image" content="{{ $seo['og_image'] }}">
    @endif

    <!-- JSON-LD Schema -->
    @if(!empty($seo['json_ld']))
        <script type="application/ld+json">{!! $seo['json_ld'] !!}</script>
    @endif

    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "WebSite",
      "name": "{{ $currentCountry->name }} Directory",
      "url": "{{ request()->getScheme() . '://' . request()->getHost() }}"
    }
    </script>
    @verbatim
    <style>
        :root {
            --primary: #2D6A4F;
            --primary-light: #52B788;
            --accent: #F4A261;
            --bg: #FAFAF8;
            --surface: #FFFFFF;
            --text: #1A1A2E;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --radius: 10px;
            --shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        a:hover {
            color: var(--primary-light);
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Navbar */
        .navbar {
            background-color: var(--surface);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }

        .brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .brand:hover {
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-link {
            color: var(--text);
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-search {
            display: flex;
            align-items: center;
        }

        .nav-search input {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius) 0 0 var(--radius);
            outline: none;
        }
        
        .nav-search input:focus {
            border-color: var(--primary);
        }

        .nav-search button {
            padding: 0.5rem 1rem;
            background-color: var(--primary);
            color: white;
            border: 1px solid var(--primary);
            border-radius: 0 var(--radius) var(--radius) 0;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .nav-search button:hover {
            background-color: var(--primary-light);
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text);
        }

        /* Main Content */
        main {
            flex: 1;
            padding-bottom: 3rem;
        }
        
        .hero {
            background-color: var(--primary);
            color: white;
            padding: 4rem 1rem;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        /* Footer */
        .footer {
            background-color: var(--surface);
            border-top: 1px solid var(--border);
            padding: 2rem 0;
            margin-top: auto;
        }
        
        .footer-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-links {
            display: flex;
            gap: 1rem;
        }
        
        .footer-links a {
            color: var(--text-muted);
        }
        
        .footer-links a:hover {
            color: var(--primary);
        }

        /* Flash Messages */
        .flash {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            color: white;
            z-index: 1000;
            box-shadow: var(--shadow);
            animation: slideIn 0.3s ease-out;
        }

        .flash-success { background-color: var(--primary); }
        .flash-error { background-color: #EF4444; }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .mobile-toggle { display: block; }
            .nav-links {
                display: none;
                position: absolute;
                top: 4rem;
                left: 0;
                right: 0;
                background-color: var(--surface);
                flex-direction: column;
                padding: 1rem;
                box-shadow: var(--shadow);
                gap: 1rem;
            }
            .nav-links.active { display: flex; }
            .nav-search { width: 100%; }
            .nav-search input { flex: 1; }
            .footer-inner { flex-direction: column; text-align: center; }
        }

        /* Components */
        .grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .grid-1 { grid-template-columns: 1fr; }
        .grid-2 { grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); }
        .grid-3 { grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); }
        .grid-4 { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
        
        .section-title {
            margin: 2rem 0 1.5rem;
            color: var(--text);
            font-size: 1.75rem;
        }

        /* Place Card Styles */
        .place-card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
        }
        
        .place-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .place-card-link {
            color: inherit;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .place-card-link:hover {
            color: inherit;
        }

        .place-card-image-wrapper {
            position: relative;
            height: 160px;
            width: 100%;
            overflow: hidden;
        }

        .place-card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .place-card:hover .place-card-image {
            transform: scale(1.05);
        }

        .place-card-placeholder {
            width: 100%;
            height: 100%;
            background-color: #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        }

        .place-card-category-badge {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            background: rgba(255, 255, 255, 0.9);
            padding: 0.25rem 0.5rem;
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text);
        }

        .place-card-content {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .place-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .place-card-address {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .place-card-featured-badge {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: var(--radius);
            font-weight: 600;
            margin-top: auto;
            align-self: flex-start;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-family: inherit;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(45, 106, 79, 0.2);
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.2s;
        }
        
        .btn:hover {
            background-color: var(--primary-light);
            color: white;
        }

        .text-error {
            color: #EF4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-top: 2rem;
        }

        .breadcrumb {
            margin: 1.5rem 0;
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        
        .breadcrumb a {
            color: var(--primary);
        }
    </style>
    @endverbatim
</head>
<body>

    <header class="navbar">
        <div class="container navbar-inner">
            <a href="{{ route('home') }}" class="brand">
                {{ current_country()->flag_emoji }} {{ current_country()->name }}
            </a>
            
            <button class="mobile-toggle" id="mobileToggle">☰</button>

            <nav class="nav-links" id="navLinks">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <!-- We could dynamically list categories here, but for now a static Search link -->
                <a href="{{ route('search.index') }}" class="nav-link">Search</a>
                
                <form action="{{ route('search.index') }}" method="GET" class="nav-search">
                    <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}" required>
                    <button type="submit">🔍</button>
                </form>
            </nav>
        </div>
    </header>

    @section('hero')
    @show

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <div>
                &copy; {{ date('Y') }} {{ current_country()->name }} Directory. All rights reserved.
            </div>
            <div class="footer-links">
                <a href="{{ route('page.show', 'about') }}">About</a>
                <a href="{{ route('contact.index') }}">Contact</a>
                <a href="{{ route('page.show', 'terms') }}">Terms</a>
            </div>
            <div>
                {{ current_country()->flag_emoji }} {{ current_country()->name }}
            </div>
        </div>
    </footer>

    @if(session('success'))
        <div class="flash flash-success" id="flashMessage">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="flash flash-error" id="flashMessage">
            {{ session('error') }}
        </div>
    @endif

    <script>
        // Mobile Menu Toggle
        document.getElementById('mobileToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
            this.textContent = this.textContent === '☰' ? '✕' : '☰';
        });

        // Auto-dismiss flash messages
        const flashMessage = document.getElementById('flashMessage');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.style.opacity = '0';
                flashMessage.style.transform = 'translateX(100%)';
                flashMessage.style.transition = 'all 0.3s ease-out';
                setTimeout(() => flashMessage.remove(), 300);
            }, 4000);
        }
    </script>
</body>
</html>
