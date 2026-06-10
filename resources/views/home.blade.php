@extends('layouts.app')

@section('hero')
<div class="hero-gradient" id="heroArea">
    <div class="hero-content-wrapper container">
        <h1 class="hero-title">
            <span class="hero-title-part discover">Discover Your</span>
            <span class="hero-title-part adventure">Next Adventure</span>
        </h1>
        <p class="hero-subtitle" id="heroSubtitle" data-text="Curated local experiences, luxury stays, and unforgettable adventures in {{ $currentCountry->name }}"></p>
        
        <form action="{{ route('search.index') }}" method="GET" class="hero-search-group" data-animate="fade-up" style="animation-delay: 800ms;">
            <div class="hero-search-input-field">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <div class="typing-placeholder-wrapper">
                    <input type="text" name="q" id="heroSearchInput" aria-label="Search places" required>
                </div>
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

        <div class="hero-stats" data-animate="fade-up" style="animation-delay: 900ms;">
            <div class="hero-stat-chip">
                <span class="hero-stat-number" data-target="{{ \App\Models\Place::count() }}">0</span>
                <span class="hero-stat-label">Verified Places</span>
            </div>
            <div class="hero-stat-chip">
                <span class="hero-stat-number" data-target="{{ $categories->count() }}">0</span>
                <span class="hero-stat-label">Categories</span>
            </div>
            <div class="hero-stat-chip">
                <span class="hero-stat-number" data-target="15">0</span>
                <span class="hero-stat-label">Cities</span>
            </div>
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
        <h2 class="section-title category-section-title" style="margin-top: 2rem;">Browse by Category</h2>
        <p class="text-muted" style="max-width: 600px; margin: 1rem auto 3rem;">Explore our curated categories to find exactly what you need.</p>
    </div>

    <div class="grid grid-3 stagger-children" data-animate="fade-up">
        @foreach($categories as $category)
            <a href="{{ route('category.show', $category->slug) }}" class="category-card" data-animate="fade-up" style="animation-delay: {{ $loop->index * 100 }}ms;">
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

    <!-- Interactive Map Teaser -->
    <section class="map-teaser-section" data-animate="fade-up" style="margin-top: 5rem;">
        <div class="map-teaser-container">
            <div class="map-teaser-content">
                <h2 class="section-title category-section-title">Explore {{ $currentCountry->name }}</h2>
                <p class="text-muted" style="margin-top: 1rem; max-width: 400px; font-size: 1.1rem;">
                    From the bustling streets of Harare to the majestic thunders of Victoria Falls. Discover the hidden gems scattered across our beautiful nation.
                </p>
                <div class="mt-4">
                    <a href="{{ route('search.index') }}" class="btn btn-primary" style="border-radius: var(--radius-full); padding: 0.8rem 2rem;">
                        View All Locations
                    </a>
                </div>
            </div>
            <div class="map-teaser-visual">
                <div class="map-glow-bg"></div>
                <!-- Stylized Zimbabwe Map SVG -->
                <svg class="stylized-map" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                    <!-- Base Map Path -->
                    <path d="M177.3,87.9c16.3-4.7,40-10.3,55.8-13.6c20.3-4.3,37.3-8.8,55.3-7.5c16.9,1.2,30.9,4.4,47.2,12.1c11.6,5.5,23.3,12.3,34.2,19.1c9.9,6.2,18.4,12.6,26.1,19.6c14.2,12.9,23.8,25.8,32.7,41.2c8.2,14.2,14.6,29,19.6,44.7c4.2,13.2,7.4,26.4,8.5,40.2c0.9,11.2,1,22.6-1,33.7c-2.4,13.3-7.2,25.8-13.6,37.7c-9.2,17.2-21.5,32-35.7,45.2c-15.6,14.5-33.1,26.3-51.8,36.2c-20.2,10.7-41.6,18.6-63.8,24.1c-17.7,4.4-35.8,7.3-54.3,7.5c-19.6,0.2-39-2.2-58.3-6c-21.7-4.3-42.6-11.2-62.8-20.1c-16.7-7.3-32.8-16.1-47.7-26.6c-11.6-8.2-22.3-17.6-32.2-27.6c-9.6-9.7-18.4-20.1-26.1-31.2c-8-11.5-14.8-23.7-20.1-36.7c-6.1-15-10.4-30.5-12.6-46.2c-1.8-13.1-2.4-26.3-1-39.2c1.7-16.1,5.8-31.6,12.1-46.2c7.8-18.1,18.6-34.4,31.7-49.2C109.3,113.6,141.5,98.2,177.3,87.9z" fill="var(--color-surface-2)" stroke="var(--color-primary)" stroke-width="2" stroke-dasharray="6,4" class="map-path-anim"/>

                    <!-- Map Grid Lines (Decorative) -->
                    <path d="M50 150 L450 150 M50 250 L450 250 M50 350 L450 350" stroke="rgba(196,98,45,0.1)" stroke-width="1" fill="none"/>
                    <path d="M150 50 L150 450 M250 50 L250 450 M350 50 L350 450" stroke="rgba(196,98,45,0.1)" stroke-width="1" fill="none"/>

                    <!-- Location Pins -->
                    <!-- Harare -->
                    <g class="map-pin-group" transform="translate(300, 180)">
                        <circle cx="0" cy="0" r="15" fill="rgba(196,98,45,0.2)" class="pin-pulse" />
                        <circle cx="0" cy="0" r="6" fill="var(--color-primary)" />
                        <text x="12" y="4" font-family="var(--font-body)" font-size="14" fill="var(--color-text)" font-weight="bold">Harare</text>
                    </g>

                    <!-- Bulawayo -->
                    <g class="map-pin-group" transform="translate(180, 320)">
                        <circle cx="0" cy="0" r="15" fill="rgba(196,98,45,0.2)" class="pin-pulse" style="animation-delay: 1s;" />
                        <circle cx="0" cy="0" r="6" fill="var(--color-primary)" />
                        <text x="-12" y="4" font-family="var(--font-body)" font-size="14" fill="var(--color-text)" font-weight="bold" text-anchor="end">Bulawayo</text>
                    </g>

                    <!-- Victoria Falls -->
                    <g class="map-pin-group" transform="translate(80, 220)">
                        <circle cx="0" cy="0" r="15" fill="rgba(232,168,56,0.2)" class="pin-pulse" style="animation-delay: 0.5s;" />
                        <circle cx="0" cy="0" r="6" fill="var(--color-accent)" />
                        <text x="12" y="4" font-family="var(--font-body)" font-size="14" fill="var(--color-text)" font-weight="bold">Victoria Falls</text>
                    </g>

                    <!-- Mutare -->
                    <g class="map-pin-group" transform="translate(400, 250)">
                        <circle cx="0" cy="0" r="15" fill="rgba(196,98,45,0.2)" class="pin-pulse" style="animation-delay: 1.5s;" />
                        <circle cx="0" cy="0" r="4" fill="var(--color-primary)" />
                        <text x="10" y="4" font-family="var(--font-body)" font-size="12" fill="var(--color-text-muted)">Mutare</text>
                    </g>
                </svg>
            </div>
        </div>
    </section>

    @if($featuredPlaces->isNotEmpty())
        <div class="mt-5 mb-4 flex items-center justify-between" data-animate="fade-up">
            <div>
                <span class="section-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Handpicked Collections
                </span>
                <h2 class="section-title category-section-title" style="margin: 0.5rem 0 0 0;">Featured Places</h2>
            </div>
        </div>
        <div class="featured-places-carousel stagger-children" data-animate="fade-up">
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
