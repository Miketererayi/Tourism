@extends('layouts.app')

@section('title', $place->title . ' - ' . $country->name)
@section('meta_description', Str::limit(strip_tags($place->description), 160))

@section('hero')
    <!-- Asymmetrical Place Gallery -->
    <div class="container" style="margin-top: 2rem;">
        @php
            $galleryImages = $place->images->take(4);
            $mockRating = number_format(4.0 + ($place->id % 10) / 10, 1);
        @endphp
        
        <div class="place-gallery-container">
            <!-- Main Featured Image -->
            <div class="gallery-main-featured" onclick="openLightbox('{{ asset('storage/' . $place->cover_image) }}', '{{ $place->title }}')" style="cursor: pointer;">
                @if($place->cover_image)
                    <img src="{{ asset('storage/' . $place->cover_image) }}" alt="{{ $place->title }}" loading="lazy">
                @else
                    <div class="place-card-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m22 8-6 4 6 4V8Z"/><rect width="14" height="12" x="2" y="6" rx="2" ry="2"/></svg>
                    </div>
                @endif
            </div>
            
            <!-- Sub Grid (4 images) -->
            <div class="gallery-sub-grid">
                @for($i = 0; $i < 4; $i++)
                    @php
                        $img = $galleryImages->get($i);
                    @endphp
                    <div class="gallery-sub-item" onclick="openLightbox('{{ $img ? asset('storage/' . $img->path) : asset('storage/' . $place->cover_image) }}', '{{ $img ? $img->alt_text : $place->title }}')" style="cursor: pointer;">
                        @if($img)
                            <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $img->alt_text }}" loading="lazy">
                        @else
                            <img src="{{ asset('storage/' . $place->cover_image) }}" alt="{{ $place->title }}" loading="lazy" style="filter: brightness(0.7) blur(1px);">
                        @endif
                    </div>
                @endfor
            </div>

            <button class="gallery-view-btn" onclick="openLightbox('{{ asset('storage/' . $place->cover_image) }}', '{{ $place->title }}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 21-4.3-4.3"/></svg>
                <span>View All Photos</span>
            </button>
        </div>
    </div>
@endsection

@section('content')

    <div class="breadcrumbs" style="padding-top: 0; margin-bottom: 1.5rem;">
        <a href="{{ route('home') }}">Home</a> 
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        @if($place->category)
            <a href="{{ route('category.show', $place->category->slug) }}">{{ $place->category->name }}</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        @endif
        <span class="breadcrumb-current">{{ $place->title }}</span>
    </div>

    <!-- Title and Badges Info Header -->
    <div class="place-info-header">
        <div class="place-title-section">
            <div>
                <h1 style="font-size: var(--text-4xl); font-weight: 800; color: var(--text); line-height: 1.2; margin: 0 0 0.5rem 0;">{{ $place->title }}</h1>
                <div class="place-profile-badges">
                    <span class="badge-tag badge-accent">Must-See</span>
                    @if($place->category)
                        <span class="badge-tag badge-primary">
                            <x-category-icon :slug="$place->category->slug" :size="12" />
                            {{ $place->category->name }}
                        </span>
                    @endif
                    <span class="badge-tag badge-rating">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        {{ $mockRating }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="place-detail-layout">
        
        <!-- Left Column -->
        <div class="place-detail-main">
            <!-- Details Grid -->
            <div class="place-details-grid">
                <!-- Coordinates -->
                <div class="place-detail-card">
                    <div class="place-detail-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div class="place-detail-card-content">
                        <span class="place-detail-card-label">Coordinates</span>
                        <span class="place-detail-card-val">{{ number_format($place->latitude ?? 45.4337, 4) }}, {{ number_format($place->longitude ?? 12.3381, 4) }}</span>
                    </div>
                </div>

                <!-- Hours -->
                <div class="place-detail-card">
                    <div class="place-detail-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="place-detail-card-content">
                        <span class="place-detail-card-label">Hours</span>
                        <span class="place-detail-card-val">Daily 8:30am - 7pm</span>
                    </div>
                </div>

                <!-- Website -->
                <div class="place-detail-card">
                    <div class="place-detail-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                    </div>
                    <div class="place-detail-card-content">
                        <span class="place-detail-card-label">Website</span>
                        @if($place->website)
                            <a href="{{ $place->website }}" target="_blank" rel="noopener noreferrer" class="place-detail-card-val" style="color: var(--primary);">{{ parse_url($place->website, PHP_URL_HOST) }}</a>
                        @else
                            <span class="place-detail-card-val">Not Available</span>
                        @endif
                    </div>
                </div>

                <!-- Phone -->
                <div class="place-detail-card">
                    <div class="place-detail-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div class="place-detail-card-content">
                        <span class="place-detail-card-label">Phone</span>
                        @if($place->phone)
                            <a href="tel:{{ $place->phone }}" class="place-detail-card-val" style="color: var(--text);">{{ $place->phone }}</a>
                        @else
                            <span class="place-detail-card-val">Not Available</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card place-description" style="box-shadow: var(--shadow); border: 1px solid var(--border); padding: 2rem; border-radius: var(--radius); line-height: 1.75;">
                <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text); margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">About</h3>
                {!! $place->description !!}
            </div>
        </div>

        <!-- Right Column / Sidebar -->
        <div class="place-detail-sidebar">
            <!-- Map Card & CTA -->
            <div class="sidebar-card" style="box-shadow: var(--shadow); border: 1px solid var(--border); padding: 1.5rem; border-radius: var(--radius);">
                <h4 style="font-size: 0.95rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.75rem; letter-spacing: 0.05em;">Map Preview</h4>
                <div class="sidebar-map-preview">
                    <!-- High fidelity mockup map graphic -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 180" style="width:100%; height:100%; background:#F1F5F9; fill:#94A3B8;">
                        <rect width="300" height="180" fill="#E2E8F0"/>
                        <!-- Stylized grid street lines -->
                        <line x1="0" y1="50" x2="300" y2="50" stroke="#CBD5E1" stroke-width="4"/>
                        <line x1="0" y1="120" x2="300" y2="120" stroke="#CBD5E1" stroke-width="4"/>
                        <line x1="80" y1="0" x2="80" y2="180" stroke="#CBD5E1" stroke-width="4"/>
                        <line x1="220" y1="0" x2="220" y2="180" stroke="#CBD5E1" stroke-width="4"/>
                        <circle cx="150" cy="90" r="14" fill="rgba(14, 165, 233, 0.2)"/>
                        <circle cx="150" cy="90" r="6" fill="#0EA5E9"/>
                    </svg>
                </div>
                <a href="https://maps.google.com?q={{ $place->latitude ?? 45.4337 }},{{ $place->longitude ?? 12.3381 }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary sidebar-cta-btn" style="width:100%; text-align:center; padding: 0.85rem !important;">
                    GET DIRECTIONS
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8c0 4.5-6 9-6 9s-6-4.5-6-9a6 6 0 0 1 12 0c0-.5 0-.5 0 0Z"/><circle cx="12" cy="8" r="2"/></svg>
                </a>
            </div>

            <!-- Lead / Contact Form -->
            <div class="sidebar-card" style="box-shadow: var(--shadow); border: 1px solid var(--border); padding: 1.5rem; border-radius: var(--radius);">
                <h3 style="margin-bottom: 1.25rem; font-size: 1.15rem; font-weight: 700; color: var(--text);">Plan Your Visit</h3>
                
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <input type="hidden" name="place_title" value="{{ $place->title }}">
                    
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <input type="text" name="name" class="form-control" placeholder="Name" required style="font-size:0.9rem; padding: 0.6rem 0.85rem;">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <input type="email" name="email" class="form-control" placeholder="Email" required style="font-size:0.9rem; padding: 0.6rem 0.85rem;">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <textarea name="message" class="form-control" rows="3" placeholder="Message" required style="font-size:0.9rem; padding: 0.6rem 0.85rem;"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; border-radius: var(--radius-sm); padding: 0.75rem 1rem; font-size: 0.95rem;">
                        Submit Request
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if($relatedPlaces->isNotEmpty())
        <div class="mt-5 pt-5" style="border-top: 1px solid var(--border-light);">
            <h2 class="section-title" style="margin-top: 0; font-size: var(--text-2xl); font-weight: 800;">More in {{ $place->category->name ?? 'this category' }}</h2>
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
