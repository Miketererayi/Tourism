@extends('layouts.app')

@section('hero')
<div class="hero-gradient" id="heroArea">
    <!-- Cursor Glow Halo -->
    <div class="cursor-halo" id="cursorHalo"></div>
    
    <div class="container" style="position: relative; z-index: 5;">
        <h1 class="hero-title" data-animate="fade-up">Discover Your Next Adventure</h1>
        <p class="hero-subtitle" data-animate="fade-up" style="animation-delay: 100ms;">Laravel-based Tourism and Local Directory in {{ $currentCountry->name }}</p>
        
        <form action="{{ route('search.index') }}" method="GET" class="hero-search-group" data-animate="fade-up" style="animation-delay: 200ms;">
            <div class="hero-search-input-field">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" name="q" placeholder="Search Hotels, Attractions in {{ $currentCountry->name }}..." required>
            </div>
            
            <div class="hero-search-divider"></div>
            
            <div class="hero-search-select-field">
                <select name="category" aria-label="Select Category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="chevron-icon"><path d="m6 9 6 6 6-6"/></svg>
            </div>

            <div class="hero-search-divider"></div>

            <div class="hero-search-select-field" style="font-weight: 600; cursor: default;">
                <span style="font-size: 1.2rem; margin-right: 0.5rem;">{{ $currentCountry->flag_emoji }}</span>
                <span>{{ $currentCountry->name }}</span>
            </div>
            
            <button type="submit" class="btn btn-primary hero-search-btn">Search</button>
        </form>

        <!-- Quick Filters -->
        <div class="quick-filters" data-animate="fade-up" style="animation-delay: 300ms;">
            @php
                $quickFilterCategories = ['hotels', 'restaurants', 'attractions', 'nightlife', 'shopping'];
            @endphp
            @foreach($categories as $category)
                @if(in_array($category->slug, $quickFilterCategories))
                    <a href="{{ route('category.show', $category->slug) }}" class="quick-filter-pill">
                        <x-category-icon :slug="$category->slug" :size="16" />
                        <span>{{ $category->name }}</span>
                    </a>
                @endif
            @endforeach
        </div>

        <div class="hero-stats" data-animate="fade-up" style="animation-delay: 400ms;">
            <span class="hero-stat-chip">
                <span style="display: inline-block; width: 6px; height: 6px; background-color: #10B981; border-radius: 50%; box-shadow: 0 0 10px #10B981; margin-right: 4px; animation: indicatorPulse 2s infinite;"></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary-light);"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                {{ \App\Models\Place::count() }}+ Verified Places
            </span>
            <span class="hero-stat-chip">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary-light);"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                {{ $categories->count() }} Categories
            </span>
        </div>
    </div>
</div>

<!-- Floating Glassmorphic Concierge Tab -->
<button class="concierge-floating-tab" id="conciergeBtn" aria-label="Open AI Concierge">
    <span class="pulse-dot"></span>
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary-light);"><path d="m12 3-1.912 5.886L5 10.8l5.088 1.914L12 18.6l1.912-5.886L19 10.8l-5.088-1.914Z"/></svg>
    <span>Ask Tariro — AI Guide</span>
</button>

<!-- AI Concierge Drawer -->
<div class="concierge-drawer" id="conciergeDrawer">
    <div class="concierge-drawer-header">
        <div class="concierge-drawer-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><path d="m12 3-1.912 5.886L5 10.8l5.088 1.914L12 18.6l1.912-5.886L19 10.8l-5.088-1.914Z"/><path d="m5 3 1 2.5L8.5 6 6 7 5 9.5 4 7 1.5 6 4 5Z"/><path d="m19 17 1 2.5 2.5.5-2.5 1-1 2.5-1-2.5-2.5-1 2.5-1Z"/></svg>
            <span>Tariro — Travel Guide</span>
        </div>
        <button class="concierge-drawer-close" id="conciergeCloseBtn" aria-label="Close Drawer">&times;</button>
    </div>
    <div class="concierge-drawer-body">
        <div class="concierge-chat-history" id="conciergeChat">
            <div class="concierge-bubble bot animate-fade-in">
                Mhoroi! 👋 I'm **Tariro**, your local guide to {{ $currentCountry->name }}. What kind of adventure are we planning today? 
            </div>
        </div>
        
        <div class="concierge-quick-prompts">
            <p style="font-size: 0.8rem; color: #64748B; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Suggested Questions</p>
            <button class="concierge-prompt-btn" data-prompt="What are the absolute must-visit attractions in Zimbabwe?">🇿🇼 Must-visit attractions</button>
            <button class="concierge-prompt-btn" data-prompt="Where can I find the best traditional or fine dining in Harare?">🍲 Top dining in Harare</button>
            <button class="concierge-prompt-btn" data-prompt="Can you plan a quick 2-day perfect itinerary for Victoria Falls?">🌊 Victoria Falls 2-Day Itinerary</button>
            <button class="concierge-prompt-btn" data-prompt="Show me unique boutique hotels or safari lodges.">🦁 Safari lodges & Boutique hotels</button>
        </div>
    </div>
</div>
@endsection

@section('content')

    <div class="mt-5 mb-5 text-center" data-animate="fade-up">
        <h2 class="section-title" style="margin-top: 1rem;">Browse by Category</h2>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto 2.5rem;">Explore our curated categories to find exactly what you need.</p>
    </div>

    <div class="grid grid-3 stagger-children" data-animate="fade-up">
        @foreach($categories as $category)
            <a href="{{ route('category.show', $category->slug) }}" class="category-card">
                <div class="category-card-icon">
                    <x-category-icon :slug="$category->slug" :size="32" />
                </div>
                <div>
                    <h3 class="category-card-name">{{ $category->name }}</h3>
                    <span class="category-card-count">
                        {{ $category->places_count }} {{ Str::plural('place', $category->places_count) }}
                    </span>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Trust / Why Us Section -->
    <section class="trust-section" data-animate="fade-up">
        <div class="text-center mb-5">
            <span class="section-label">Why Choose Us</span>
            <h2 class="section-title" style="margin-top: 0.5rem;">Trusted by Thousands</h2>
        </div>
        <div class="trust-grid">
            <div class="trust-card">
                <div class="trust-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <h3 class="trust-title">Local Experts</h3>
                <p class="trust-desc">Every listing is curated by people who know the area best, ensuring authenticity and quality.</p>
            </div>
            <div class="trust-card">
                <div class="trust-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                </div>
                <h3 class="trust-title">Verified Listings</h3>
                <p class="trust-desc">All businesses and places are verified for accuracy, so you can explore with confidence.</p>
            </div>
            <div class="trust-card">
                <div class="trust-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                </div>
                <h3 class="trust-title">Always Free</h3>
                <p class="trust-desc">Our directory is completely free to use. Discover, explore, and connect — no fees, ever.</p>
            </div>
        </div>
    </section>

    @if($featuredPlaces->isNotEmpty())
        <div class="mt-5 mb-4 flex items-center justify-between" data-animate="fade-up">
            <div>
                <span class="section-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Featured
                </span>
                <h2 class="section-title" style="margin: 0;">Featured Places</h2>
            </div>
        </div>
        <div class="grid grid-3 stagger-children" data-animate="fade-up">
            @foreach($featuredPlaces as $place)
                <x-place-card :place="$place" />
            @endforeach
        </div>
    @endif

    @if($latestPlaces->isNotEmpty())
        <div class="mt-5 mb-4 flex items-center justify-between" data-animate="fade-up">
            <h2 class="section-title" style="margin: 0;">Latest Listings</h2>
            <a href="{{ route('search.index') }}" class="btn btn-primary" style="font-size: 0.875rem;">View All &rarr;</a>
        </div>
        <div class="grid grid-4 stagger-children" data-animate="fade-up">
            @foreach($latestPlaces as $place)
                <x-place-card :place="$place" />
            @endforeach
        </div>
    @endif

@endsection
