<div class="place-card">
    <a href="{{ route('place.show', $place->slug) }}" class="place-card-link">
        <div class="place-card-image-wrapper">
            @if($place->cover_image)
                <img src="{{ asset('storage/' . $place->cover_image) }}" alt="{{ $place->title }}" class="place-card-image" loading="lazy">
            @else
                <div class="place-card-placeholder">
                    <span>No Image</span>
                </div>
            @endif
            
            @if($place->category)
                <span class="place-card-category-badge">{{ $place->category->icon }} {{ $place->category->name }}</span>
            @endif
        </div>
        
        <div class="place-card-content">
            <h3 class="place-card-title">{{ $place->title }}</h3>
            
            @if($place->address)
                <p class="place-card-address">
                    📍 {{ \Illuminate\Support\Str::limit($place->address, 50) }}
                </p>
            @endif
            
            @if($place->is_featured)
                <span class="place-card-featured-badge">⭐ Featured</span>
            @endif
        </div>
    </a>
</div>
