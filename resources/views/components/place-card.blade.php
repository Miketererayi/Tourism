<div class="card place-card">
    <a href="{{ route('place.show', $place->slug) }}" class="place-card-link">
        <div class="place-card-image-wrapper">
            @if($place->cover_image)
                <img src="{{ asset('storage/' . $place->cover_image) }}" alt="{{ $place->title }}" class="place-card-image" loading="lazy">
                <div class="place-card-overlay"></div>
            @else
                <div class="place-card-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5;"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                </div>
            @endif
            
            @if($place->category)
                <span class="place-card-category-badge">
                    <x-category-icon :slug="$place->category->slug" :size="14" />
                    {{ $place->category->name }}
                </span>
            @endif
        </div>
        
        <div class="place-card-content">
            <h3 class="place-card-title">{{ $place->title }}</h3>
            
            @if($place->address)
                <div class="place-card-address">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span>{{ \Illuminate\Support\Str::limit($place->address, 50) }}</span>
                </div>
            @endif
            
            @if($place->is_featured)
                <span class="place-card-featured-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Featured
                </span>
            @endif
        </div>
    </a>
</div>
