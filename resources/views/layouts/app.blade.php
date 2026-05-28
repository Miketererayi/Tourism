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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles and Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <header class="navbar">
        <div class="container navbar-inner">
            <a href="{{ route('home') }}" class="brand">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                {{ $currentCountry->name }} Directory
            </a>
            
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle Menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
            </button>

            <nav class="nav-links" id="navLinks">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('search.index') }}" class="nav-link">Explore</a>
                
                <form action="{{ route('search.index') }}" method="GET" class="nav-search">
                    <input type="text" name="q" placeholder="Search places..." value="{{ request('q') }}" required>
                    <button type="submit" aria-label="Search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </button>
                </form>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                        {{ $currentCountry->name }} Directory
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
                        <input type="email" placeholder="Enter your email">
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
