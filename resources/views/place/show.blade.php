@extends('layouts.app')

@section('title', $place->title . ' - ' . $country->name)
@section('meta_description', Str::limit(strip_tags($place->description), 160))

@section('hero')
    @if($place->cover_image)
        <div class="place-hero">
            <img src="{{ asset('storage/' . $place->cover_image) }}" alt="{{ $place->title }}" loading="lazy">
            <div class="place-hero-overlay"></div>
            
            <div class="container place-hero-content">
                <h1>{{ $place->title }}</h1>
                <div class="place-hero-badges">
                    @if($place->category)
                        <span class="place-hero-badge">
                            <x-category-icon :slug="$place->category->slug" :size="16" />
                            {{ $place->category->name }}
                        </span>
                    @endif
                    
                    @if($place->is_featured)
                        <span class="place-hero-badge place-hero-badge-featured">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Featured
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="hero-gradient" style="padding: 6rem 0;">
            <div class="container" style="position: relative; z-index: 1; text-align: center;">
                <h1 class="hero-title">{{ $place->title }}</h1>
                <div class="place-hero-badges" style="justify-content: center;">
                    @if($place->category)
                        <span class="place-hero-badge">
                            <x-category-icon :slug="$place->category->slug" :size="16" />
                            {{ $place->category->name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection

@section('content')

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a> 
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        @if($place->category)
            <a href="{{ route('category.show', $place->category->slug) }}">{{ $place->category->name }}</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        @endif
        <span class="breadcrumb-current">{{ $place->title }}</span>
    </div>

    <div class="place-detail-layout">
        
        <!-- Left Column -->
        <div class="place-detail-main">
            @if(!$place->cover_image)
            <div style="margin-bottom: 2rem;">
                <h2 class="section-title" style="margin-top: 0;">About</h2>
            </div>
            @endif

            <div class="card place-description">
                {!! $place->description !!}
            </div>

            @if($place->images && $place->images->isNotEmpty())
                <h3 class="section-title">Gallery</h3>
                <div class="grid grid-3" id="gallery">
                    @foreach($place->images as $image)
                        <div class="card gallery-item" onclick="openLightbox('{{ asset('storage/' . $image->path) }}', '{{ $image->alt_text }}')">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->alt_text }}" loading="lazy">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Column / Sidebar -->
        <div class="place-detail-sidebar">
            
            <div class="sidebar-card">
                <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem; font-weight: 700; color: var(--text);">Contact Information</h3>
                
                <ul class="contact-list">
                    @if($place->address)
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span style="font-weight: 500;">{{ $place->address }}</span>
                        </li>
                    @endif
                    
                    @if($place->phone)
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                            <a href="tel:{{ $place->phone }}" style="font-weight: 600; color: var(--text);">{{ $place->phone }}</a>
                        </li>
                    @endif
                    
                    @if($place->email)
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            <a href="mailto:{{ $place->email }}" style="font-weight: 600; color: var(--primary);">{{ $place->email }}</a>
                        </li>
                    @endif
                    
                    @if($place->website)
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                            <a href="{{ $place->website }}" target="_blank" rel="noopener noreferrer" style="font-weight: 600; color: var(--primary);">{{ parse_url($place->website, PHP_URL_HOST) ?? 'Visit Website' }}</a>
                        </li>
                    @endif
                </ul>
            </div>

            @if($place->latitude && $place->longitude)
                <div class="sidebar-card map-card">
                    <div class="map-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>
                        <span class="map-coords">{{ number_format($place->latitude, 4) }}, {{ number_format($place->longitude, 4) }}</span>
                        
                        <a href="https://maps.google.com?q={{ $place->latitude }},{{ $place->longitude }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary map-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8c0 4.5-6 9-6 9s-6-4.5-6-9a6 6 0 0 1 12 0c0-.5 0-.5 0 0Z"/><circle cx="12" cy="8" r="2"/></svg>
                            Get Directions
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($relatedPlaces->isNotEmpty())
        <div class="mt-5 pt-5" style="border-top: 1px solid var(--border-light);">
            <h2 class="section-title" style="margin-top: 0;">More in {{ $place->category->name ?? 'this category' }}</h2>
            <div class="related-scroll">
                @foreach($relatedPlaces as $related)
                    <div class="related-scroll-item">
                        <x-place-card :place="$related" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <button class="lightbox-close" aria-label="Close lightbox">&times;</button>
        <img id="lightbox-img" src="" alt="">
    </div>

    <script>
        function openLightbox(src, alt) {
            const lb = document.getElementById('lightbox');
            const img = document.getElementById('lightbox-img');
            img.src = src;
            img.alt = alt || '';
            lb.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('is-open');
            document.body.style.overflow = '';
        }
        
        // Close lightbox on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeLightbox();
            }
        });
    </script>
@endsection
