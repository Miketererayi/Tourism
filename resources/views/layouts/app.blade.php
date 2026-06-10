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
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- Styles and Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Custom Cursor (Desktop Only) -->
    <div class="custom-cursor-ring" id="customCursorRing"></div>
    <div class="custom-cursor-dot" id="customCursorDot"></div>

    <header class="navbar" id="mainNavbar">
        <div class="container navbar-inner">
            <a href="{{ route('home') }}" class="brand">
                <span class="brand-dot"></span>
                <span>LOCAL <span style="color: var(--color-primary);">EXPLORE</span></span>
            </a>
            
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle Menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
            </button>

            <nav class="nav-links" id="navLinks">
                <a href="{{ route('home') }}" class="nav-link">Destinations</a>
                <a href="{{ route('search.index') }}" class="nav-link">Categories</a>
                <a href="{{ route('contact.index') }}" class="nav-btn-primary">Add Place</a>
                
                <div class="country-dropdown">
                    <button class="country-btn" id="countryDropdownBtn" aria-label="Select Country">
                        <span class="flag" style="font-size: 1.1rem;">{{ $currentCountry->flag_emoji }}</span>
                        <span class="country-name">{{ $currentCountry->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-primary);"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div class="country-dropdown-menu" id="countryDropdownMenu">
                        @foreach(\App\Models\Country::where('is_active', true)->get() as $c)
                            <a href="//{{ $c->domain }}" class="country-dropdown-item {{ $c->id === $currentCountry->id ? 'active' : '' }}">
                                <span class="flag">{{ $c->flag_emoji }}</span>
                                <span>{{ $c->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </nav>
        </div>
    </header>

    @section('hero')
    @show

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer-dark">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand Column -->
                <div>
                    <div class="footer-brand">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span style="font-weight: 800; letter-spacing: -0.02em;">LOCAL <span style="color: var(--primary);">EXPLORE</span></span>
                    </div>
                    <p class="footer-tagline">Your trusted guide to the best places, services, and businesses across {{ $currentCountry->name }}.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                        </a>
                        <a href="#" aria-label="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                        <a href="#" aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                        </a>
                    </div>
                </div>
                
                <!-- Links Column -->
                <div>
                    <h4 class="footer-heading">Quick Links</h4>
                    <nav class="footer-nav">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('search.index') }}">Explore</a>
                        <a href="{{ route('page.show', 'about') }}">About</a>
                        <a href="{{ route('contact.index') }}">Contact</a>
                        <a href="{{ route('page.show', 'terms') }}">Terms</a>
                    </nav>
                </div>
                
                <!-- Newsletter Column -->
                <div>
                    <h4 class="footer-heading">Stay Updated</h4>
                    <p class="footer-tagline" style="margin-bottom: 1rem;">Get notified when new places are added to the directory.</p>
                    <div class="footer-newsletter">
                        <input type="email" aria-label="Email address for newsletter" placeholder="Enter your email">
                        <button type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                &copy; {{ date('Y') }} {{ $currentCountry->name }} Directory. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scroll-top-btn" aria-label="Scroll to top">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    </button>

    <!-- Toast Container -->
    <div id="toast-container" class="toast-container">
        @if(session('success'))
            <div class="flash flash-success" onclick="this.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                {{ session('success') }}
                <button class="flash-close" aria-label="Close">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="flash flash-error" onclick="this.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                {{ session('error') }}
                <button class="flash-close" aria-label="Close">&times;</button>
            </div>
        @endif
    </div>

    <script>
        // Mobile Menu Toggle
        const mobileToggle = document.getElementById('mobileToggle');
        if(mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                document.getElementById('navLinks').classList.toggle('active');
                const isOpen = document.getElementById('navLinks').classList.contains('active');
                if (isOpen) {
                    this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>';
                } else {
                    this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>';
                }
            });
        }

        // Country Dropdown Toggle
        const countryDropdownBtn = document.getElementById('countryDropdownBtn');
        const countryDropdownMenu = document.getElementById('countryDropdownMenu');
        if (countryDropdownBtn && countryDropdownMenu) {
            countryDropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                countryDropdownMenu.classList.toggle('active');
            });
            document.addEventListener('click', function(e) {
                if (!countryDropdownBtn.contains(e.target) && !countryDropdownMenu.contains(e.target)) {
                    countryDropdownMenu.classList.remove('active');
                }
            });
        }

        // Auto-dismiss flash messages
        document.querySelectorAll('.flash').forEach(flash => {
            setTimeout(() => {
                flash.style.opacity = '0';
                flash.style.transform = 'translateX(100%)';
                flash.style.transition = 'all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1)';
                setTimeout(() => flash.remove(), 300);
            }, 4000);
        });
    </script>
</body>
</html>
