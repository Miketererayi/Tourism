@extends('layouts.app')

@section('title', $place->title . ' - ' . $country->name)
@section('meta_description', Str::limit(strip_tags($place->description), 160))

@section('hero')
    @if($place->cover_image)
        <div style="width: 100%; max-height: 500px; overflow: hidden; background: #000;">
            <img src="{{ asset('storage/' . $place->cover_image) }}" alt="{{ $place->title }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9;" loading="lazy">
        </div>
    @else
        <div style="width: 100%; height: 200px; background: var(--primary); display: flex; align-items: center; justify-content: center;">
            <h2 style="color: white; opacity: 0.5;">{{ $place->title }}</h2>
        </div>
    @endif
@endsection

@section('content')

    <div class="breadcrumb" style="margin-top: 2rem;">
        <a href="{{ route('home') }}">Home</a> &gt; 
        @if($place->category)
            <a href="{{ route('category.show', $place->category->slug) }}">{{ $place->category->name }}</a> &gt; 
        @endif
        {{ $place->title }}
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 2rem; margin-top: 1rem;">
        
        <!-- Left Column -->
        <div style="flex: 1; min-width: 300px;">
            <div style="margin-bottom: 2rem;">
                <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem; color: var(--text);">{{ $place->title }}</h1>
                
                <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    @if($place->category)
                        <a href="{{ route('category.show', $place->category->slug) }}" style="display: inline-block; background: var(--surface); border: 1px solid var(--border); padding: 0.25rem 0.75rem; border-radius: var(--radius); color: var(--text); font-weight: 500;">
                            {{ $place->category->icon }} {{ $place->category->name }}
                        </a>
                    @endif
                    
                    @if($place->is_featured)
                        <span style="background: var(--accent); color: white; padding: 0.25rem 0.75rem; border-radius: var(--radius); font-weight: 600; font-size: 0.875rem;">⭐ Featured</span>
                    @endif
                </div>
            </div>

            <div style="background: var(--surface); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow); margin-bottom: 2rem; line-height: 1.8;">
                {!! $place->description !!}
            </div>

            @if($place->images && $place->images->isNotEmpty())
                <h3 style="margin-bottom: 1rem; font-size: 1.5rem;">Gallery</h3>
                <div class="grid grid-4" id="gallery">
                    @foreach($place->images as $image)
                        <div style="height: 120px; border-radius: var(--radius); overflow: hidden; cursor: pointer;" onclick="openLightbox('{{ asset('storage/' . $image->path) }}', '{{ $image->alt_text }}')">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->alt_text }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" loading="lazy">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Column / Sidebar -->
        <div style="width: 100%; max-width: 350px; position: sticky; top: 5rem; align-self: flex-start;">
            <div style="background: var(--surface); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); margin-bottom: 1.5rem;">
                <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Contact Information</h3>
                
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem;">
                    @if($place->address)
                        <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                            <span style="font-size: 1.25rem;">📍</span>
                            <span>{{ $place->address }}</span>
                        </li>
                    @endif
                    
                    @if($place->phone)
                        <li style="display: flex; gap: 0.75rem; align-items: center;">
                            <span style="font-size: 1.25rem;">📞</span>
                            <a href="tel:{{ $place->phone }}" style="color: var(--text);">{{ $place->phone }}</a>
                        </li>
                    @endif
                    
                    @if($place->email)
                        <li style="display: flex; gap: 0.75rem; align-items: center;">
                            <span style="font-size: 1.25rem;">✉️</span>
                            <a href="mailto:{{ $place->email }}" style="color: var(--text);">{{ $place->email }}</a>
                        </li>
                    @endif
                    
                    @if($place->website)
                        <li style="display: flex; gap: 0.75rem; align-items: center;">
                            <span style="font-size: 1.25rem;">🌐</span>
                            <a href="{{ $place->website }}" target="_blank" rel="noopener noreferrer">{{ parse_url($place->website, PHP_URL_HOST) ?? 'Visit Website' }}</a>
                        </li>
                    @endif
                </ul>
            </div>

            @if($place->latitude && $place->longitude)
                <div style="background: var(--surface); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
                    <div style="background: #E5E7EB; height: 150px; display: flex; align-items: center; justify-content: center; position: relative;">
                        <span style="font-size: 2rem;">🗺️</span>
                        <a href="https://maps.google.com?q={{ $place->latitude }},{{ $place->longitude }}" target="_blank" rel="noopener noreferrer" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.5); color: white; font-weight: bold; opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                            View on Google Maps
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($relatedPlaces->isNotEmpty())
        <div style="margin-top: 4rem;">
            <h2 class="section-title">More in {{ $place->category->name ?? 'this category' }}</h2>
            <div style="display: flex; gap: 1.5rem; overflow-x: auto; padding-bottom: 1rem; scroll-snap-type: x mandatory;">
                @foreach($relatedPlaces as $related)
                    <div style="min-width: 250px; scroll-snap-align: start; flex: 1;">
                        <x-place-card :place="$related" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Simple Lightbox -->
    <div id="lightbox" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.9); z-index: 1000; align-items: center; justify-content: center; padding: 2rem;" onclick="closeLightbox()">
        <span style="position: absolute; top: 1rem; right: 2rem; color: white; font-size: 2rem; cursor: pointer;">&times;</span>
        <img id="lightbox-img" src="" alt="" style="max-width: 100%; max-height: 90vh; object-fit: contain;">
    </div>

    <script>
        function openLightbox(src, alt) {
            const lb = document.getElementById('lightbox');
            const img = document.getElementById('lightbox-img');
            img.src = src;
            img.alt = alt || '';
            lb.style.display = 'flex';
        }
        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
        }
    </script>
@endsection
