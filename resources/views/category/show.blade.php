@extends('layouts.app')

@section('title', $category->name . ' in ' . $currentCountry->name)
@section('meta_description', 'Browse the best ' . $category->name . ' in ' . $currentCountry->name)

@section('hero')
<div class="category-hero">
    <div class="container" style="position: relative; z-index: 1;">
        <div class="category-hero-icon">
            <x-category-icon :slug="$category->slug" :size="32" />
        </div>
        <h1>{{ $category->name }}</h1>
        <p class="category-hero-count">{{ $places->total() }} {{ Str::plural('place', $places->total()) }} found</p>
    </div>
</div>
@endsection

@section('content')
    <div class="catalog-layout">
        
        <!-- Filter Sidebar -->
        <aside class="filter-sidebar">
            <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filter Sidebar
            </h3>
            
            <!-- Categories -->
            <div class="filter-section">
                <h4 class="filter-title">Categories</h4>
                <div class="filter-list">
                    @foreach(\App\Models\Category::where('country_id', $currentCountry->id)->active()->ordered()->get() as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" class="filter-item {{ $cat->id === $category->id ? 'font-bold' : '' }}" style="color: {{ $cat->id === $category->id ? 'var(--primary)' : 'inherit' }}">
                            <div class="filter-item-left">
                                <x-category-icon :slug="$cat->slug" :size="16" />
                                <span>{{ $cat->name }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            
            <!-- Rating -->
            <div class="filter-section">
                <h4 class="filter-title">Rating</h4>
                <div class="filter-list">
                    <label class="filter-item">
                        <div class="filter-item-left">
                            <input type="checkbox" checked style="accent-color: var(--primary);">
                            <span>{{ $currentCountry->name }}</span>
                        </div>
                        <span class="filter-item-count">{{ $places->total() }}</span>
                    </label>
                    <label class="filter-item">
                        <div class="filter-item-left">
                            <input type="checkbox" style="accent-color: var(--primary);">
                            <span>Rating</span>
                        </div>
                        <span class="filter-item-count">3</span>
                    </label>
                    <label class="filter-item">
                        <div class="filter-item-left">
                            <input type="checkbox" style="accent-color: var(--primary);">
                            <span>Amenities</span>
                        </div>
                        <span class="filter-item-count">3</span>
                    </label>
                </div>
            </div>

            <!-- Amenities -->
            <div class="filter-section">
                <h4 class="filter-title">Amenities</h4>
                <div class="filter-list">
                    <label class="filter-item">
                        <div class="filter-item-left">
                            <input type="checkbox" style="accent-color: var(--primary);">
                            <span>WiFi Included</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Country -->
            <div class="filter-section" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                <h4 class="filter-title">Country</h4>
                <div class="filter-list">
                    <div class="filter-item" style="cursor: default;">
                        <div class="filter-item-left">
                            <span style="font-size: 1.2rem;">{{ $currentCountry->flag_emoji }}</span>
                            <span style="font-weight: 600;">{{ $currentCountry->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Catalog Panel -->
        <div class="catalog-main">
            <div class="breadcrumbs" style="padding-top: 0;">
                <a href="{{ route('home') }}">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                <span class="breadcrumb-current">{{ $category->name }}</span>
            </div>

            <div class="flex items-center justify-between mb-4" style="flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <h2 style="font-size: var(--text-3xl); font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 0.75rem; margin: 0;">
                    <x-category-icon :slug="$category->slug" :size="28" />
                    {{ $category->name }}
                </h2>
                
                <form action="{{ route('category.show', $category->slug) }}" method="GET" class="category-search" style="box-shadow: var(--shadow-sm); border-radius: var(--radius);">
                    <input type="text" name="q" placeholder="Search in {{ $category->name }}..." value="{{ $searchQuery }}" style="border-radius: var(--radius) 0 0 var(--radius);">
                    <button type="submit" aria-label="Search" style="border-radius: 0 var(--radius) var(--radius) 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </button>
                </form>
            </div>

            @if($places->isEmpty())
                <div class="empty-state">
                    <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><circle cx="12" cy="12" r="10"/><path d="M16 16s-1.5-2-4-2-4 2-4 2"/><line x1="9" x2="9.01" y1="9" y2="9"/><line x1="15" x2="15.01" y1="9" y2="9"/></svg>
                    <h2 style="font-weight: 800; margin-bottom: 0.5rem; color: var(--text);">No places found</h2>
                    <p class="text-muted mb-4">We couldn't find any places matching your criteria.</p>
                    <a href="{{ route('category.show', $category->slug) }}" class="btn btn-primary">Clear Search</a>
                    <a href="{{ route('home') }}" class="btn" style="background: var(--surface); color: var(--text); border: 1px solid var(--border); margin-left: 0.5rem;">Go Home</a>
                </div>
            @else
                <div class="grid grid-3 stagger-children" data-animate="fade-up">
                    @foreach($places as $place)
                        <x-place-card :place="$place" />
                    @endforeach
                </div>

                <div class="mt-5">
                    {{ $places->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
